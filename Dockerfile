# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones necesarias de PHP
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mysqli gd

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Copiar el contenido de src al servidor web
COPY src/ /var/www/html/

# Dar permisos a los archivos
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Exponer el puerto 80
EXPOSE 80
