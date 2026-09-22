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
# ഈ രണ്ട് വരികൾ ചേർക്കുക
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
# ഡിപൻഡൻസികൾ ഇൻസ്റ്റാൾ ചെയ്യുന്നു
RUN composer install --no-dev --optimize-autoloader

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

# പെർമിഷനുകൾ ശരിയാക്കുന്നു
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

# ഡിപൻഡൻസികൾ ഇൻസ്റ്റാൾ ചെയ്യുന്നു
RUN composer install --no-dev --optimize-autoloader

# Render നൽകുന്ന $PORT ഉപയോഗിക്കാൻ Shell ഫോർമാറ്റിൽ റൺ ചെയ്യുന്നു
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}