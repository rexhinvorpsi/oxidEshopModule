### Oxid Eshop Module Implementation
- Problem : Adding an attachment module to the category main view to upload links and files,
- Requirements : Oxid Eshop 4.10 or higher
- Optional Requirement : Docker Dev Environment
###### Module folder is  `/modules/rvp/categoryattachment`

### Instalation Proccess
I used  **.docker ** folder to hold my docker config and vhost .
**Docker Configuration:**
```bash
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
```

I used a docker compose to make building and deploying faster 
**Docker Compose Configuration:**
```yaml
version: '3'
services:
  app:
    build:
      context: .
      dockerfile: .docker/Dockerfile
    image: trial-task
    ports:
      - 8080:80
    volumes:
      - .:/var/www/html/
    links:
      - mysql
    environment:
      DB_HOST: mysql
      DB_DATABASE: test-shop
      DB_USERNAME: test
      DB_PASSWORD: test123
  mysql:
    image: mysql:5.7
    ports:
      - 13306:3306
    environment:
      MYSQL_DATABASE: test-shop
      MYSQL_USER: test
      MYSQL_PASSWORD: test123
      MYSQL_ROOT_PASSWORD: test123
```
To build and open  the application just use `docker-compose up --build`


### Concepts Used 
- MVC Pattern
- PHP Classes polymorphism and inheritance
- Smarty template engine







