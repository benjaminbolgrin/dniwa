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
			composer require inertiajs/inertia-laravel && \
			php artisan breeze:install blade && \
			npm install @inertiajs/inertia @inertiajs/inertia-vue3 vue@next @inertiajs/progress && \
			npm install -D @vue/compiler-sfc && \
			npm install --save-dev @vitejs/plugin-vue && \
			npm install && \
			mkdir -p /var/www/html/public/static && \
			cd /var/www/html/public/static && \
			curl -LO 'https://github.com/twbs/bootstrap/releases/download/v5.3.2/bootstrap-5.3.2-dist.zip' && \
			unzip -q 'bootstrap-5.3.2-dist.zip' && \
			rm 'bootstrap-5.3.2-dist.zip' && \
			cd /var/www/html/storage/logs && \
			touch 'laravel.log' && \
			chmod 777 'laravel.log' && \
			cd /var/www/html
CMD ["docker-php-entrypoint", "php-fpm"]
