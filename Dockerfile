FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev libonig-dev \
    && docker-php-ext-install \
    intl mbstring pdo_pgsql pgsql \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' \
    /etc/apache2/sites-available/000-default.conf
RUN chown -R www-data:www-data writable \
    && chmod -R 775 writable
EXPOSE 10000
CMD ["apache2-foreground"]
