# BITMANAGE

## Install - default
```
cp .env.dist .env
composer install
```

## Install - docker
```
    docker-compose build
    docker-compose up
    docker exec -it bitmanage-php-fpm bash
    cp .env.dist .env
    composer install
```    
Run: `127.0.0.1:7717`