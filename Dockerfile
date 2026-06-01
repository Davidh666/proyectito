# Usamos una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalamos extensiones necesarias para PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copiamos todo tu código a la carpeta del servidor
COPY . /var/www/html/

# Damos permisos
RUN chown -R www-data:www-data /var/www/html