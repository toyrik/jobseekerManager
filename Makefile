up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear manager-clear docker-pull docker-build docker-up manager-init
test: manager-test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

manager-init: manager-composer-install manager-assets-install manager-migrations manager-ready

manager-clear:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine rm -f .ready

manager-ready:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine touch .ready

manager-composer-install:
	docker-compose run --rm manager-php-cli composer install

manager-migrations:
	docker-compose run --rm manager-php-cli php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose run --rm manager-php-cli chmod 777 var/data.db

manager-test:
	docker-compose run --rm manager-php-cli php bin/phpunit

manager-assets-install:
	docker-compose run --rm manager-node yarn install

manager-assets-dev:
	docker-compose run --rm manager-node npm run dev
