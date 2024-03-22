FROM php:8.2-alpine3.19

RUN addgroup -S app && adduser -S app -G app

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

COPY --chown=app:app composer.json composer.lock ./
RUN composer install --no-scripts

RUN mv .env.example .env

RUN chown -R app:app .
RUN chmod -R 777 storage

RUN php artisan key:generate

USER app

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]