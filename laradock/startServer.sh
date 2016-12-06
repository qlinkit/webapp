#/bin/bash
docker-compose stop && docker-compose up -d php-fpm nginx redis mongo
