# DNIWA development infrastructure
The development infrastructure is utilizing docker containers.

## There are 4 containers specified in the /compose.yaml file.

### dniwa-nginx
The 'dniwa-nginx' container serves web pages and exposes port 80 to the host's port 8080.
When 'dniwa-nginx' is running, web pages can be reached on the host from **127.0.0.1:8080**.
The static CSS and Javascript files are stored within the container at /var/www/html/public/static/.

### dniwa-php-fpm
Web requests for php files are forwarded to the 'dniwa-php-fpm' container by 'dniwa-nginx'.
This container stores Laravel's files at /var/www/html/.

### dniwa-mariadb
This container holds the project's SQL database.

### dniwa-redis
This container is the queue driver for Laravel jobs.

## Set up
Create a '.secrets' directory in the project's root directory.
Move the 'dniwa.env' file to the '.secrets' directory.
Make desired changes to the 'dniwa.env' file. (e.g. change database user and/or password etc.)

## Start up
To start the development infrastructure, run the following command from the project's root directory as a priviliged user:

**docker compose up** or **docker compose up --detach**

## Database migrations
Database migrations need to be performed by the 'dniwa-php-fpm' container.
As a privileged user, you can run the following command to make migrations:

**docker exec dniwa-php-fpm php artisan migrate**

## Build assets (JS, CSS)

**docker exec dniwa-php-fpm npm run build**

## DBMS settings
If you want to make changes to the DBMS (e.g. change database or user name in /.secrets/dniwa.env), after the first invocation of 'docker compose up', you need to delete the corresponding docker volume. By doing so, you will lose all previously saved data.

**docker volume rm dniwa_vol-mariadb**
