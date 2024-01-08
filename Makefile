install:
	composer install

generate key:
	php artisan key:generate

migrate:
	php artisan migrate

start:
	php artisan serve