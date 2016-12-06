# Qlink.it Web Application

## Table of contents

* [Requirements](#requirements) 
* [Installation](#installation)
* [Configuration](#configuration)
* [Run application](/#run-application)
* [Dockerized application](#dockerized-application)
* [About](#about)

### [Requirements](#requ)

The Web application requires the following programs to be installed to run:

* PHP 5.6.x
* Redis server version 2.4.x / 3.2.x
* MongoDB version v2.6.x / v3.4.x


### [Installation](#inst)

#### 1) Checkout a repository 
Checkout a repository from https://github.com/qlinkit/webapp 

```bash
git clone https://github.com/qlinkit/webapp 
```

#### 2) Download composer 
Download composer.phar from https://getcomposer.org/download/  


#### 3) Run composer 
Run composer in the main folder of the cloned repository to install the vendor of [Laravel PHP Framework](https://laravel.com/docs/4.2) and all the necessary dependencies

```bash
composer.phar install
```

#### 4) Update class autoloader   
Run the following commands in the main folder

```bash
mkdir app/src/Qlink/Commands
mkdir app/storage/meta
mkdir app/storage/views
mkdir app/storage/logs
chmod -R 777 app/storage
```

Update the PSR-0 class autoloader information ( Run this command each time you add a PHP class to the project ).

```bash
php artisan dump-autoload
```
or

```bash
composer.phar dumpautoload
```

#### 5) PHP extensions   
You need install PHP 5.6 Redis and Mongo extensions.


### [Configuration](#conf)

#### 1) Configure MongoDB

Create a MongoDB database and user

* Connect to mongo client
```bash
mongo
```
* Then execute the following statements

```sql
use qlinkmemory;
db.createUser({user:'qlinkuser', pwd:'w3lc0m3', roles: [{role:"readWrite", db: "qlinkmemory"}]});
db.createCollection('qlink_memory');
```

#### 2) Configure Redis
Configure your Redis server config and set your password.

#### 3) Configure Environments and DB connections

* Define your *local, QAT, UAT, production* environment. For example:

For use config for local environment ( placed in app/config/local/ folder ), set de environment variable ENV_NAME to 'local' in the shell console

```bash
export ENV_NAME=local
```

* Configure de MongoDB and Redis databases connections in **app/config/{local/production/QAT/UAT}/database.php**. For example:

```php
                ...
                // MONGO
                'qlink_mongodb' => array(
                        'driver'   => 'mongodb',
                        'host'     => 'localhost',
                        'port'     => 27017,
                        'username' => 'qlinkuser',
                        'password' => 'w3lc0m3',
                        'database' => 'qlinkmemory'
                ),
                ...
                ...
                
                // REDIS
                'default' => array(
                        'host'     => '127.0.0.1',
                        'port'     => 6379,
                        'password' => 'qwerty',
                        'database' => 7,
                ),

                'ip' => array(
                    'host'     => '127.0.0.1',
                    'port'     => 6379,
                    'password' => 'qwerty',
                    'database' => 1,
                ),
                ...
                ...
```

* Configure the application parameters for the different environments in **app/config/qlinkconfig.php**. For example:

```php
    ...
    'local' => array(
        'site_url' => 'http://my-domain',
        'secure_site' => false,
        'enabled_anti_fire' => false,
        'expire_seconds' => 86400, //24horas
        'allowed_servers' => array(
                "one",
                "two"
        ),
        'current_storage' => 'two',
        'qlink_corporate_site_url' => 'http://my-domain/main'
    ),
    ...
    ...
```

* Compiling CSS: To compile the CSS you need to have [Sass](http://sass-lang.com/install) and [Compass](http://compass-style.org/install/) installed. Once installed run the following script:

```bash
cd theme/qlink_web/sass
compass watch
```

Then, if you modify the .sass files stored in theme/qlink_web/sass/, you will find the css compiled in **theme/qlink_web/css/global.css**. Then run:

```bash
cp theme/qlink_web/css/global.css public/css/
```

Finally, to minimize the .js and .css files execute the following script (this step require a JRE java installed):

```bash
./minify.sh 
```


### [Run application](#run)

To run the web application you need install and run a web application server as nginx. Then, do:

1. Install NGINX application web server in your host.

2. Add this enrty in your hosts file (usually /etc/hosts):<br><br>
```
    127.0.0.1       qlink 
```

3. Configure the nginx server to serve the qlink web application. For example, assuming / var / www is the main application folder, configure the new web server as follows:<br><br>
```
server {

    listen 80;
    listen [::]:80;

    server_name qlink;
    root /var/www/public;
    index index.php index.html index.htm;

    location / {
         try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_pass php-upstream;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```


### [Dockerized application](#dock)

If you do not have enough time to invest in the configuration and installation of the necessary components, you may want to follow the steps we propose to run the dockerized application using [docker-compose](https://docs.docker.com/compose/) and [laradock](https://github.com/laradock/laradock).

Do the following:

a. Run '**composer install**' as explained in the [Installation](/#inst) section.

b. Add this enrty in your hosts file (usually /etc/hosts):<br><br>
```
    127.0.0.1       qlink 
```
c. Install and run the **Docker Engine** following the steps described in [Install Docker](https://docs.docker.com/compose/install/).

d. In **laradock** folder of our project, run the following bash script to build and run docker containers:<br><br>
```
cd laradock
```
```
./createProyect.sh 
```
e. Then, open [http://qlink/](http://qlink/) in your browser. That is all.

*PD: You will also find the following scripts to re-build, stop, start and connect to the workspace by ssh (rebuildProyect.sh, stopServer.sh, startServer.sh and connectSSH.sh)*

### [About](#abou)
Qlink.it application is distributed under [MIT license](https://opensource.org/licenses/MIT). You can read more about this project at [https://qlink.it/main](https://qlink.it/main).
