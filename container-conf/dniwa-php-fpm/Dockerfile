FROM php:8.2.6-fpm-alpine
WORKDIR /var/www/html
RUN apk update && apk add curl \
			composer \
			npm \
			php-xml \
			php-dom \
			php-curl \
			php-session \
			php-tokenizer \
			php-xmlwriter \
			php-fileinfo && \
			docker-php-ext-install mysqli pdo pdo_mysql && \
			composer create-project laravel/laravel . && \
			composer require laravel/breeze && \
			php artisan breeze:install blade
CMD ["docker-php-entrypoint", "php-fpm"]
