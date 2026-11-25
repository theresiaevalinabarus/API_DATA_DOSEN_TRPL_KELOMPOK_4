FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libpq-dev libicu-dev libzip-dev libonig-dev \
    && docker-php-ext-install -j"$(nproc)" \
    intl mbstring pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

COPY . .

EXPOSE 8080

CMD ["sh", "-c", "mkdir -p /tmp/ci-writable/cache /tmp/ci-writable/logs /tmp/ci-writable/session /tmp/ci-writable/uploads && php spark serve --host 0.0.0.0 --port ${PORT:-8080}"]