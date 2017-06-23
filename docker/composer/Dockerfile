# Composer Docker Container
FROM composer:latest

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow

# Add support for Composer
RUN curl -LsS https://getcomposer.org/composer.phar -o /usr/local/bin/composer
RUN set -ex && chmod +x /usr/local/bin/composer

RUN mkdir -p /composer
RUN chown www-data:www-data /composer

ADD start.sh /start.sh

RUN usermod -s /bin/bash -u 1000 www-data
RUN ["chmod", "+x", "/start.sh"]
USER 1000

ENTRYPOINT ["/start.sh"]
