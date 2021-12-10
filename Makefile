include .env

PHP_SERVICE_NAME = php
APP_DIR ?= $(shell pwd)
TESTS_PHP_VERSION ?= 8.0

.PHONY: shell
shell:
	run
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
	docker-compose run --rm ${PHP_SERVICE_NAME} ash -c "composer install && composer test"

test-php-version:
	docker run --rm -it -v ${APP_DIR}:/app -w /app webdevops/php:${TESTS_PHP_VERSION}-alpine bash -c "composer install && composer test"