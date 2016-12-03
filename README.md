# Qlink.it Web Application

## Table of contents

* [Requirements](#requ) 
* [Installation](#inst)
* [Configuration](#conf)
* [Run application](#run)
* [About](#abou)

### [Requirements](#requ)

The Web application requires the following programs to be installed to run:

* PHP 5.6.x
* Redis server version 2.4.x
* MongoDB version v2.6.x


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
```

Update the PSR-0 class autoloader information ( Run this command each time you add a PHP class to the project ).

```bash
php artisan dump-autoload
```
or
```bash
composer.phar dumpautoload
```


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
Configure your Redis server config and set your password (*in the following project it is assumed that the password is "qwerty"*)

#### 3) Configure Environments and DB connections

* Define your *local, QAT, UAT, production* environment in **bootstrap/start.php**. For example:

```php
$env = $app->detectEnvironment(array(
    'local' => array(‘hostname_local’),
    'production' => array('hostname_production'),
));
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
        'piwik_tracker_url' => 'http://my-domain/piwik.php',
        'enabled_piwik' => false,
        'site_url' => 'http://my-domain',
        'secure_site' => false,
        'enabled_anti_fire' => false,
        'expire_seconds' => 86400, //24horas
        'allowed_servers' => array(
                "one",
                "two"
        ),
        'current_storage' => 'two',
        'allowed_html_tags' => '<div><span><p><a><b><img><br><ul><li><strong>',
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


### [About](#abou)
Qlink.it application is distributed under [MIT license](https://opensource.org/licenses/MIT). You can read more about this project at https://qlink.it/main.
