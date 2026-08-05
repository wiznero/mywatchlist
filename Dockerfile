FROM php:8.2-apache

# Instalar extensiones de base de datos
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar todo tu proyecto a la raíz de Apache
COPY . /var/www/html/

# Cambiar el puerto al de Railway, limpiar módulos y arrancar Apache
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && a2dismod mpm_event mpm_worker 2>/dev/null || true && a2enmod mpm_prefork && apache2-foreground                               