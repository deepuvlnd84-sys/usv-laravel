FROM php:8.2-apache

# ആവശ്യമായ പാക്കേജുകളും PostgreSQL/NodeJS എക്സ്റ്റൻഷനുകളും ഇൻസ്റ്റാൾ ചെയ്യുന്നു
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mbstring zip

# Apache mod_rewrite എനേബിൾ ചെയ്യുന്നു (Laravel റൂട്ടുകൾ പ്രവർത്തിക്കാൻ)
RUN a2enmod rewrite

# Apache DocumentRoot Laravel-ന്റെ public/ ഫോൾഡറിലേക്ക് മാറ്റുന്നു
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Composer ഇൻസ്റ്റാൾ ചെയ്യുന്നു
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Storage, bootstrap/cache പെർമിഷനുകൾ നൽകുക
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ഡിപൻഡൻസികൾ ഇൻസ്റ്റാൾ ചെയ്യുന്നു
RUN composer install --no-dev --optimize-autoloader

# Frontend അസറ്റുകൾ ബിൽഡ് ചെയ്യുന്നു
RUN npm install && npm run build

# Laravel ക്യാഷ് ഒപ്റ്റിമൈസ് ചെയ്യുന്നു
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Render പോർട്ട് ലിസൺ ചെയ്യുന്നതിനുള്ള സ്ക്രിപ്റ്റ്
CMD (php artisan migrate --force || true) && sed -i "s/80/${PORT:-80}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf && apache2-foreground