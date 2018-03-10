#!/bin/sh

set -e

cd /application && nohup ./bin/console server:run 0.0.0.0:8000 > /var/log/phpd.log 2>&1 &

sleep infinity