FROM php:8.1.5-apache

WORKDIR /var/www/html/php-app

COPY . .

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
# RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mysqli \
    mbstring \
    exif \
    pcntl
EXPOSE 80
# For live code changes without rebuilding every time, you can use volume mounting:
# docker run --rm --name my-php-app -p 80:80 -v C:\xampp\htdocs\docker-php-app:/var/www/html/php-app php-app:v1
# docker run --rm --name my-php-app -p 80:80 php-app:v1

