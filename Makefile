include .env

DOCKER_COMPOSE = docker compose

.PHONY: build
build:
	@$(DOCKER_COMPOSE) build

.PHONY: sh
sh:
	@$(DOCKER_COMPOSE) exec -ti php sh

.PHONY: php
php:
	@$(DOCKER_COMPOSE) exec php php $(filter-out $@,$(MAKECMDGOALS))

.PHONY: console
console:
	@$(DOCKER_COMPOSE) exec php bin/console $(filter-out $@,$(MAKECMDGOALS))

.PHONY: composer
composer:
	@$(DOCKER_COMPOSE) exec php composer $(filter-out $@,$(MAKECMDGOALS))

# https://stackoverflow.com/a/6273809/1826109
%:
	@:
