#/bin/bash
docker-compose stop && docker-compose up -d php-fpm nginx redis mongo
docker-compose exec mongo bash -C '/root/mongoDBCreate.sh'
