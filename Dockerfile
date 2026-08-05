FROM dunglas/frankenphp

# Extensiones de PHP
RUN install-php-extensions pdo_mysql mysqli

# Directorio de trabajo
WORKDIR /app

# Copiar todo el contenido del proyecto
COPY . .                                                   