FROM php:8.2-cli

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies (ignore ext-gd)
RUN composer install --ignore-platform-req=ext-gd --no-interaction --optimize-autoloader

# Generate key
RUN php artisan key:generate

# Expose port
EXPOSE ${PORT:-8000}

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}