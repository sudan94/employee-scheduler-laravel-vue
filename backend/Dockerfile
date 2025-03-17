FROM php:8.2-apache as web

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libpq-dev \
    libmcrypt-dev \
    netcat-traditional \
    cron \
    dos2unix

# clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Set up cron
COPY cronjob /etc/cron.d/laravel-cron
RUN dos2unix /etc/cron.d/laravel-cron

RUN chmod 0644 /etc/cron.d/laravel-cron && \
    crontab /etc/cron.d/laravel-cron && \
    touch /var/log/cron.log && \
    chmod 0666 /var/log/cron.log


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# new one
WORKDIR /app
COPY . .

# Install project dependencies
RUN composer install

EXPOSE 8000
