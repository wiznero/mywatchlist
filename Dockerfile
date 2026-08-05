FROM php:8.2-apache

# Instalar extensiones de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Corregir el conflicto de MPMs en Apache
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Copiar el proyecto a la raíz de Apache
COPY . /var/www/html/                                          