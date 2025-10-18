FROM php:8.2-fpm

# Instala dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html
COPY docker-script.sh /usr/local/bin/docker-script.sh
RUN chmod +x /usr/local/bin/docker-script.sh

ENTRYPOINT ["/usr/local/bin/docker-script.sh"]
CMD ["php-fpm"]
