FROM php:8.2-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY ./PistonLogistics /var/www/html


RUN chmod 777 ./ -R
# Install any needed packages specified in the requirements.txt
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install

# Set up Apache configuration
RUN a2enmod rewrite
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80 for Apache
EXPOSE 80

# Define environment variables for Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update the default Apache site with the configured virtual host
RUN sed -ri -e "s|DocumentRoot /var/www/html|DocumentRoot \${APACHE_DOCUMENT_ROOT}|g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Start Apache


