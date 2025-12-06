FROM php:8.2-apache

# 1. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 2. Install System Dependencies & Extensions
RUN apt-get update && apt-get install -y \
    apt-utils nodejs git zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libjpeg-dev libfreetype6-dev libpq-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# 3. Apache Configuration (CRITICAL FOR YOUR STRUCTURE)
RUN a2enmod rewrite

# Point Apache to the 'public' folder, not the root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Use sed to replace the default /var/www/html with our new public path in Apache config files
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# 4. Set Working Directory to Root (Where composer.json lives)
WORKDIR /var/www/html

# 5. Copy Composer files and Install Dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# 6. Copy the rest of your application code
COPY . .

# 7. Set Permissions
# Apache runs as www-data, so it needs ownership of the files you just copied
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80