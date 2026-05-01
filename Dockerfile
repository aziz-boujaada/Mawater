FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=node:20 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:20 /usr/local/bin/npm /usr/local/bin/npm

WORKDIR /app
COPY . .
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build || true

EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000