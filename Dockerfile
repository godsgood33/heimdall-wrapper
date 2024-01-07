FROM php:8.2-apache

COPY app/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html/*
COPY 000-default.conf /etc/apache2/sites-available/
