FROM dunglas/frankenphp

# Extensiones de PHP
RUN install-php-extensions pdo_mysql mysqli

# Definir directorio de trabajo
WORKDIR /app

# Copiar el proyecto
COPY . /app

# Indicar el directorio raíz del sitio web
ENV FRANKENPHP_CONFIG="root /app"