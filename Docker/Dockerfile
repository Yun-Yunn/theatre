# Use a base image with PHP and Apache
FROM php:8.2-apache-buster

# Set ServerName in Apache configuration
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install required dependencies for PHP (and wkhtmltopdf(traduction html en pdf))
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip wkhtmltopdf \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash \
    && apt-get install -y nodejs

# Configure and install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql opcache intl zip calendar dom mbstring gd xsl \
    && pecl install apcu \
    && docker-php-ext-enable apcu
RUN a2enmod rewrite

# Set the ulimit
RUN ulimit -n 8192

# Set the working directory
WORKDIR /var/www/

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
