FROM phpdockerio/php71-fpm:latest

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php-memcached php7.1-mysql php-redis php7.1-bcmath php7.1-bz2 php7.1-gd php-imagick php7.1-intl php7.1-mbstring php7.1-xsl php-yaml php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

USER www-data

WORKDIR "/application"