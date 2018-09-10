### Requirements 

PHP >= 7.1.3

OpenSSL PHP Extension

PDO PHP Extension

Mbstring PHP Extension

### Installing

run composer install

copy env.example to .env and update the .env file with the MySQL database and user and pass

run php artisan migrate

run php artisan db:seed

php -S localhost:8000 -t public