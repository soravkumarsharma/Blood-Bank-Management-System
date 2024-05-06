FROM php:apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /var/www/html
COPY ./Blood_Bank/ .
RUN chmod -R 777 ./donor_image ./request_image
EXPOSE 80
CMD ["apache2-foreground"]
