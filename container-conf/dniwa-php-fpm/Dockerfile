FROM php:8.2.6-fpm-alpine
RUN apk update && apk add curl \
			composer \
			php-xml \
			php-dom \
			php-curl \
			php-session \
			php-tokenizer \
			php-xmlwriter \
			php-fileinfo
CMD ["docker-php-entrypoint", "php-fpm"]
