FROM php:5.4-apache
RUN docker-php-ext-install mysql mbstring
RUN ["apt-get", "update"]
RUN ["apt-get", "install", "-y", "vim"]
