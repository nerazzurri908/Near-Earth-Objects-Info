# Near-Earth-Objects-Info
Laravel 8.1

Simple service for lookup Near-Earth Objects (asteroids) based on their closest approach date to Earth.


### FUNCTIONALITY: ###

* Search for Asteroids based on their closest approach date to Earth
* Sort asteroids by speed


### CODE USED: ###

* Laravel 8.1.
* PHP/mySQL.
* PHPUnit
* Docker, Docker Compose



## Configure docker-compose file ##

*You will need to make an account with [NASA APIs] (https://api.nasa.gov/) to use api key(NASA_ASTEROIDS_API_KEY) required for this website*

* Go to project root directory

* Open docker-compose file and change Database AND NASA_ASTEROIDS_API_KEY credentials.

* Open docker-compose file and change APP_KEY  AND  APP_TEST_KEY by key generated with command "hp artisan key:generate --show" from /pathToProject/ProjectDir/laravel/.

* Open docker-compose file and change values in parametrs 'user' and 'uid' (line 7 and 8) with
your name and uid.
  You can get your pc account_name when enter "whoami" command in console
  You can get your pc account_uid when enter "id -u" command in console



## How to set this project up ##

+ Open console(cmd) and go to project root directory typing command "cd path-to-project"

+ Call "docker-compose build" to build docker image

+ Call "docker-compose up -d" to run containers in background mode

+ Call "docker exec asteroid-app composer install" to load project dependencies via composer

+ Call "docker exec asteroid-app php artisan migrate" to migrate database schema to app database

+ Call "docker exec asteroid-app php artisan migrate --database=testing" to migrate database schema to test database

+ Call "docker exec asteroid-app php artisan asteroids:create" to fulfill app database with data

+ Call "docker exec asteroid-app php artisan test --testsuite=Feature --stop-on-failure" to run tests


