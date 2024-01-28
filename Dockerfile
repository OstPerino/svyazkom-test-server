FROM php:8.1-fpm
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www
COPY . /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
