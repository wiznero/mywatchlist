FROM dunglas/frankenphp

# Extensiones de PHP
RUN install-php-extensions pdo_mysql mysqli

# Directorio de trabajo
WORKDIR /app

# Copiar el código del proyecto
COPY . /app

# Indicar a FrankenPHP la raíz del servidor y el puerto de Railway
ENV SERVER_NAME=":8080 /app"