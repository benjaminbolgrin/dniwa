FROM nginx:1.25.3-alpine
RUN mkdir -p /var/www/html/public/static && \
	cd /var/www/html/public/static && \
	curl -LO 'https://github.com/twbs/bootstrap/releases/download/v5.3.2/bootstrap-5.3.2-dist.zip' && \
	unzip -q 'bootstrap-5.3.2-dist.zip' && \
	rm 'bootstrap-5.3.2-dist.zip' && \
	mkdir -p /var/www/html/public/static/vuejs && \
	cd /var/www/html/public/static/vuejs && \
	curl -LO 'https://unpkg.com/vue@3/dist/vue.global.js'
COPY ./container-conf/dniwa-nginx/nginx.conf /etc/nginx/conf.d/default.conf

