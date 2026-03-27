FROM php:8.2-apache

# Install required system packages
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    && docker-php-ext-install curl

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
