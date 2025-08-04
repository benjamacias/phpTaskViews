FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli

# Copy application code
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
