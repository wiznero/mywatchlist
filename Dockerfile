FROM dunglas/frankenphp

# Instalar las extensiones de PHP necesarias para MySQL
RUN install-php-extensions pdo_mysql mysqli

# Establecer el directorio de trabajo en la ubicación que espera FrankenPHP
WORKDIR /app

# Copiar todo el código de tu proyecto al contenedor
COPY . /app