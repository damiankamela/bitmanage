#!/usr/bin/env bash

until cd /application
do
    echo "Retrying composer install"
done

cd /application && composer install --prefer-source --no-interaction