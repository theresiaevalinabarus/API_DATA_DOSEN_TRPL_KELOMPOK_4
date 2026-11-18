FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev libonig-dev \
    && docker-php-ext-install \
    intl mbstring pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN mkdir -p /tmp/ci-writable/cache \
    /tmp/ci-writable/logs \
    /tmp/ci-writable/session \
    /tmp/ci-writable/uploads

EXPOSE 8080

CMD ["sh", "-c", "php spark serve --host 0.0.0.0 --port ${PORT:-8080}"]
