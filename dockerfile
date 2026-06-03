FROM php:8.1.5-apache

WORKDIR /var/www/html/php-app

COPY . .

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80
# For live code changes without rebuilding every time, you can use volume mounting:
# docker run --rm --name my-php-app -p 80:80 -v C:\xampp\htdocs\docker-php-app:/var/www/html/php-app php-app:v1
# docker run --rm --name my-php-app -p 80:80 php-app:v1

