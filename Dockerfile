FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y ca-certificates \
    nano git unzip libzip-dev libonig-dev libxml2-dev libssl-dev \
    libpng-dev libjpeg-dev libfreetype6-dev nginx curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip exif pcntl bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY apps .

RUN composer install --no-dev --optimize-autoloader

COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80 443 7774 884 9000 3306 4444

CMD service nginx start && php-fpm