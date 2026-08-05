FROM php:8.2-apache

# Instalar las extensiones de MySQL para PDO y MySQLi
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar todo el código a la carpeta raíz de Apache
COPY . /var/www/html/                                              