FROM php:php-version-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get dist-upgrade -y \
    && apt-get install -y \
    	build-essential \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        locales \
        zip \
        jpegoptim optipng pngquant gifsicle \
        nano \
        unzip \
        git \
        curl \
    && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-configure gd \
    --with-gd --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for application
RUN groupadd -g app-gid www
RUN useradd -u app-uid -ms /bin/bash -g www www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]