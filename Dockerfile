FROM php:8.1-apache
# Instalamos las librerías necesarias y los certificados SSL
RUN apt-get update && apt-get install -y libssl-dev ca-certificates
RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html