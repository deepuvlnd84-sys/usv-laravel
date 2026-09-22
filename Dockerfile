FROM php:8.2-cli

# സിസ്റ്റം പാക്കേജുകളും PHP എക്സ്റ്റൻഷനുകളും ഇൻസ്റ്റാൾ ചെയ്യുന്നു
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Composer ഇൻസ്റ്റാൾ ചെയ്യുന്നു
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# ഡിപൻഡൻസികൾ ഇൻസ്റ്റാൾ ചെയ്യുന്നു
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

# ആപ്പ് റൺ ചെയ്യുന്നു
CMD php artisan serve --host=0.0.0.0 --port=8080