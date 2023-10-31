# DNIWA development infrastructure
The development infrastructure is utilizing docker containers.

## There are 3 containers specified in the /compose.yaml file.

### dniwa-nginx
The 'dniwa-nginx' container serves web pages and exposes port 80 to the host's port 8080.
When 'dniwa-nginx' is running, web pages can be reached on the host from **127.0.0.1:8080**.
The static CSS and Javascript files are stored within the container at /var/www/html/public/static/.

### dniwa-php-fpm
Web requests for php files are forwarded to the 'dniwa-php-fpm' container by 'dniwa-nginx'.
This container stores Laravel's files at /var/www/html/.

### dniwa-mariadb
This container holds the project's SQL database.

## Start up
To start the development infrastructure run the following command from the project's root directory as a priviliged user.
**docker compose up** or **docker compose up --detach**

## Database migrations
Database migrations need to be performed by the 'dniwa-php-fpm' container.
As a privileged user, you can run the following command to make migrations.
**docker exec dniwa-php-fpm php artisan migrate**
