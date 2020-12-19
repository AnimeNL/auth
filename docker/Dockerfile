FROM php:7.4-fpm-alpine3.12

# install composer
RUN apk update && \
    apk add --no-cache git wget && \
    git clone https://github.com/AnimeNL/auth.git /var/www/auth

COPY entrypoint.sh /entrypoint.sh

WORKDIR /var/www/auth
RUN chmod +x /entrypoint.sh && \
    mkdir -p var/oauth && \
    wget https://getcomposer.org/download/1.10.19/composer.phar && \
    docker-php-ext-install pdo pdo_mysql && \
    php composer.phar install

RUN apk del --purge git wget 

RUN cat /entrypoint.sh
RUN ls -al /var/www/auth/

ENTRYPOINT ["/entrypoint.sh"]