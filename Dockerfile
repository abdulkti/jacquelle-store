FROM php:8.2-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libpq-dev git unzip \
    && docker-php-ext-install intl pgsql pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

EXPOSE 7860
ENV PORT=7860
CMD php spark serve --host 0.0.0.0 --port $PORT
