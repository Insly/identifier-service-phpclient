include .env

PHP_SERVICE_NAME = php
APP_DIR ?= $(shell pwd)
TESTS_PHP_VERSION ?= 8.0
CURRENT_UID ?= 1000

.PHONY: shell
shell:
	docker-compose exec ${PHP_SERVICE_NAME} ash

.PHONY: run
run:
	docker-compose up -d

.PHONY: stop
stop:
	docker-compose stop

.PHONY: build
build:
	docker-compose pull

.PHONY: test
test:
	docker-compose run --rm ${PHP_SERVICE_NAME} ash -c "rm composer.lock; composer install && composer test"

test-php-version:
	docker run --rm --user ${CURRENT_UID} --volume ${APP_DIR}:/app --workdir /app jakzal/phpqa:php${TESTS_PHP_VERSION}-alpine ash -c "rm composer.lock; composer install && composer test"
