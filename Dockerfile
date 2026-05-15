FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable rewrite (important for PHP apps)
RUN a2enmod rewrite

# Configure Apache MPM
RUN apachectl -M | grep mpm
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2enmod mpm_prefork

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
