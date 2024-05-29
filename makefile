stan:
	php vendor/bin/phpstan analyse -l max src tests

coverage:
	docker container exec skillcheck-endpoint-w-php-1 ./vendor/bin/phpunit --coverage-html var/code-coverage

unit:
	docker container exec skillcheck-endpoint-w-php-1 ./vendor/bin/phpunit tests

startup:
	composer install
	docker-compose up --build -d

up:
	docker-compose up

down:
	docker-compose stop