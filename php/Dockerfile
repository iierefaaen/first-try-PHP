FROM php:8.2-fpm

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install pdo pdo_mysql mysqli

# (Optional) Tambah tools CLI (kalau kamu butuh)
# RUN apt-get update && apt-get install -y vim git unzip

# Set working directory
WORKDIR /var/www/html
