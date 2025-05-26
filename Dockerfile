# Gunakan PHP dengan Apache sebagai dasar
FROM php:7.4-apache

# Instal alat yang dibutuhkan untuk CodeIgniter
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip

# Aktifkan fitur URL di Apache
RUN a2enmod rewrite

# Salin proyek ke dalam "wadah"
COPY . /var/www/html/

# Beri izin agar bisa dijalankan
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Buka port 80 untuk website
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]