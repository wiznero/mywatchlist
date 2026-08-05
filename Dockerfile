FROM dunglas/frankenphp

# Instalar las extensiones de PHP necesarias para MySQL
RUN install-php-extensions pdo_mysql mysqli

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar todo el código de tu proyecto al contenedor
COPY . /app

# Indicar a FrankenPHP que sirva los archivos desde la raíz de /app
CMD ["frankenphp", "php-server", "--root", "/app"]