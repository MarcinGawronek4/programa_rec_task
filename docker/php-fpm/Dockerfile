FROM php:8.4-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install unzip git -y
RUN \
    apt-get update && \
    apt-get install libldap2-dev -y && \
    rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo_mysql
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
