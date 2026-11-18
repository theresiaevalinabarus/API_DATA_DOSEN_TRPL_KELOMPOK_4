
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

# Set CodeIgniter public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    && sed -ri \
    's/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

# Set writable permissions
RUN chown -R www-data:www-data writable \
    && chmod -R 775 writable

# Hostless supplies PORT at runtime
EXPOSE 8080

CMD ["bash", "-c", "PORT=${PORT:-8080}; sed -ri \"s/Listen 80/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -ri \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; exec apache2-foreground"]
