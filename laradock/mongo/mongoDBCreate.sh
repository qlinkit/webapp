#/bin/bash
mongo qlinkmemory --eval "db.createUser({user:'qlinkuser', pwd:'w3lc0m3', roles: [{role:'readWrite', db: 'qlinkmemory'}]});"
mongo qlinkmemory --eval "db.createCollection('qlink_memory');"
