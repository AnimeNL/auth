FROM php:8.4-fpm-alpine3.22

COPY . /var/www/auth

COPY docker/entrypoint.sh /entrypoint.sh

WORKDIR /var/www/auth
RUN chmod +x /entrypoint.sh && \
    mkdir -p var/oauth && \
    wget https://getcomposer.org/download/2.2.6/composer.phar && \
    docker-php-ext-install pdo pdo_mysql && \
    php composer.phar install

RUN cat /entrypoint.sh
RUN ls -al /var/www/auth/

ENTRYPOINT ["/entrypoint.sh"]
