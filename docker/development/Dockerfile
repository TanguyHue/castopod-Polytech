####################################################
# Castopod development Docker file
####################################################
# ⚠️ NOT optimized for production
# should be used only for development purposes
#---------------------------------------------------

# Stage 1: Composer dependencies
FROM composer:2 AS composertemp

WORKDIR /app

# Copy only composer files
COPY composer.json composer.lock ./

# Create the directory for Composer scripts
COPY modules/Admin/Language/ modules/Admin/Language/

# Install dependencies
RUN composer install --ignore-platform-req=ext-gd --ignore-platform-req=ext-intl

# Stage 2: PHP runtime environment
FROM php:8.1-fpm

LABEL maintainer="Yassine Doghri <yassine@doghri.fr>"

# Install system dependencies
RUN apt-get update && apt-get install --yes --no-install-recommends \
    git \
    gnupg \
    openssh-client \
    cron \
    unzip \
    libicu-dev \
    libpng-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libzip-dev \
    ffmpeg \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-webp --with-jpeg --with-freetype \
    && docker-php-ext-install gd \
    && docker-php-ext-install exif \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && echo "file_uploads = On\n" \
         "memory_limit = 512M\n" \
         "upload_max_filesize = 500M\n" \
         "post_max_size = 512M\n" \
         "max_execution_time = 300\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

# Install Node.js and pnpm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install --yes nodejs \
    && npm install -g pnpm

# Set up work directory
WORKDIR /castopod

COPY . .

# Copy application files from Composer stage
COPY --from=composertemp /usr/bin/composer /usr/bin/composer
COPY --from=composertemp /app/vendor /castopod/vendor

# Set up cron
COPY crontab /etc/cron.d/castopod-cron
RUN chmod 0644 /etc/cron.d/castopod-cron && crontab /etc/cron.d/castopod-cron

COPY package.json /tmp/package.json
RUN cd /tmp && pnpm install
RUN cp -a /tmp/node_modules /castopod
RUN cd /castopod

# Build static assets
RUN pnpm run build:static

# Run the application with cron and PHP server
CMD /bin/sh -c "(crontab /castopod/crontab && cron && service cron reload && php spark serve --host 0.0.0.0) & npm run dev -- --host"
