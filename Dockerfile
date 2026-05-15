FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable rewrite (important for PHP apps)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . /var/www/html/

# Fix permissions (important on Render)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80