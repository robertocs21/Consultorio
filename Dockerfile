# Imagen de producción del consultorio: PHP con Apache, con la versión de PHP fijada aquí.
# Para aplicar un parche de seguridad de PHP basta con cambiar la etiqueta de abajo y hacer push.

# Dependencias de Composer (solo para construir; Composer no queda en la imagen final)
FROM composer:2 AS dependencias
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# 8.5.12 corrige php2shell (CVE-2026-109618 y CVE-2026-109619)
FROM php:8.5.12-apache

# mysqli (con mysqlnd) para conectar con MySQL en Railway
RUN docker-php-ext-install mysqli

# PHP: configuración de producción más los ajustes de la app
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php.ini "$PHP_INI_DIR/conf.d/consultorio.ini"

# Apache: sirve public/ en el puerto 8080 (el que espera DigitalOcean) y lee los .htaccess
COPY docker/apache.conf /etc/apache2/conf-available/consultorio.conf
RUN a2enmod rewrite \
    && a2enconf consultorio \
    && sed -i 's/^Listen 80$/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i -e 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' \
              -e 's#DocumentRoot /var/www/html$#DocumentRoot /var/www/html/public#' \
              /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .
COPY --from=dependencias /app/vendor ./vendor

EXPOSE 8080
