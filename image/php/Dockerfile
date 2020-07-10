FROM php:7.4-fpm

RUN apt-get update && apt-get install -y zip unzip git libmcrypt-dev \
    && docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install supervisor
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor
ADD ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

# Set supervisor to manage container processes
ENTRYPOINT ["/usr/bin/supervisord"]