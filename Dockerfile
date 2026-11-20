FROM php:8.3-apache

# MySQL kapcsolatához szükséges PHP bővítmény telepítése
RUN docker-php-ext-install pdo pdo_mysql

# Saját alkalmazásfájlok bemásolása a webszerver gyökerébe
COPY src/ /var/www/html/

EXPOSE 80