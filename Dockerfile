FROM php:7.2-cli
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install libmcrypt-dev -y
RUN pecl install mcrypt-1.0.1 && docker-php-ext-enable mcrypt