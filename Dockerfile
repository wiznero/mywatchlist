FROM php:8.2-apache

# Instalar extensiones de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar el proyecto a la raíz de Apache
COPY . /var/www/html/

# Forzar la limpieza de módulos conflictivos y arrancar Apache en TIEMPO DE EJECUCIÓN
CMD bash -c "a2dismod mpm_event mpm_worker 2>/dev/null || true && a2enmod mpm_prefork && apache2-foreground"                                  