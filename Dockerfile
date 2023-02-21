# Partimos de la imagen php en su versión 7.4
FROM php:8-fpm

# Copiamos los archivos package.json composer.json y composer-lock.json a /var/www/
COPY composer*.json /var/www/

# Nos movemos a /var/www/
WORKDIR /var/www/

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    locales \
    zip \
    vim \
    git \
    curl

# Instalamos extensiones de PHP
RUN docker-php-ext-install zip exif pcntl

# Instalamos composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalamos dependendencias de composer
RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

# Exponemos el puerto 9000 a la network
EXPOSE 9000

# Corremos el comando php-fpm para ejecutar PHP
#CMD ["php-fpm"]
