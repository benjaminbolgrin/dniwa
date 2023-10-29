FROM php:8.2.6-fpm-alpine
WORKDIR /var/www/html
RUN apk update && apk add curl \
			composer \
			php-xml \
			php-dom \
			php-curl \
			php-session \
			php-tokenizer \
			php-xmlwriter \
			php-fileinfo && \
			composer create-project laravel/laravel .
CMD ["docker-php-entrypoint", "php-fpm"]
