build:
	composer install
	docker-compose up -d
	bin/console doctrine:database:crete
	bin/console doctrine:schema:update --force
	bin/console server:run

test:
	php vendor/bin/simple-phpunit -c phpunit.xml --coverage-html ./build