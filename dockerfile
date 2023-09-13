# Use a imagem oficial do PHP
FROM php7.4-fpm

# Instale as extensões PHP necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Defina o diretório de trabalho
WORKDIR varwwwhtml

# Instale o Composer globalmente
RUN curl -sS httpsgetcomposer.orginstaller  php -- --install-dir=usrlocalbin --filename=composer

# Copie o código-fonte do Laravel para o contêiner
COPY . .

# Instale as dependências do Composer
RUN composer install

# Exponha a porta 9000
EXPOSE 9000

# Inicialize o servidor PHP-FPM
CMD [php-fpm]
