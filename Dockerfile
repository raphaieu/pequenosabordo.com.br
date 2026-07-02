# Stage 1: Build frontend (Vue/Vite)
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js tailwind.config.js postcss.config.js index.html style.css ./
COPY src ./src
COPY images ./images
COPY css ./css
COPY js ./js

# Apenas vite build (sync-images.php roda no entrypoint com volume de uploads)
RUN npx vite build

# Stage 2: Install PHP dependencies
FROM composer:2 AS vendor

WORKDIR /app

COPY admin/composer.json admin/composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Stage 3: Production image (nginx + php-fpm)
FROM php:8.3-fpm-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Frontend build
COPY --from=frontend /app/dist ./dist

# Admin (PHP)
COPY admin ./admin
COPY --from=vendor /app/vendor ./admin/vendor

# Imagens estáticas do site (não são uploads de produtos)
COPY images ./images

# Imagens de produtos de produção (seed para volume na primeira subida)
COPY public/images/produtos ./seed/images/produtos

# Configurações Docker
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/99-custom.ini
COPY docker/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && rm -f /etc/nginx/sites-enabled/default \
    && mkdir -p /var/www/html/public/images/produtos \
    && mkdir -p /var/www/html/dist/images/produtos \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
