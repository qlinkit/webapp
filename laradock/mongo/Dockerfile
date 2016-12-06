FROM mongo:latest

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

#COPY mongo.conf /usr/local/etc/mongo/mongo.conf

VOLUME /data/db /data/configdb

COPY mongoDBCreate.sh /root/mongoDBCreate.sh
RUN chmod 777 /root/mongoDBCreate.sh

CMD ["mongod"] 

EXPOSE 27017

