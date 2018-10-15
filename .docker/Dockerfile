FROM php:5.6.8-apache


COPY . /var/www/html/
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN apt-get update \
    && apt-get install libpng12-dev libfreetype6-dev libjpeg62-turbo-dev -qy \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install mbstring pdo pdo_mysql  mysql && chown -R www-data:www-data /var/www/html/ \
    && a2enmod rewrite
RUN docker-php-ext-install gd