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
			php artisan breeze:install blade && \
			mkdir -p /var/www/html/public/static && \
			cd /var/www/html/public/static && \
			curl -LO 'https://github.com/twbs/bootstrap/releases/download/v5.3.2/bootstrap-5.3.2-dist.zip' && \
			unzip -q 'bootstrap-5.3.2-dist.zip' && \
			rm 'bootstrap-5.3.2-dist.zip' && \
			composer require inertiajs/inertia-laravel
CMD ["docker-php-entrypoint", "php-fpm"]
