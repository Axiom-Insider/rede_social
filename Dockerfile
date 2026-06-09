FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./

RUN composer install 

COPY . /var/www/html

RUN mkdir -p /var/www/html/cache \
    && chown -R www-data:www-data /var/www/html/cache \
    && chmod -R 775 /var/www/html/cache

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
/etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' \
/etc/apache2/apache2.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/g' \
/etc/apache2/apache2.conf

EXPOSE 80