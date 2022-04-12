all: help

SHELL:=/bin/bash

.PHONY: help up debug down shell install logs test

help: Makefile
	@sed -n 's/^##//p' $<

## install: 	        Install packages.
install:
	docker-compose run --rm php composer install

## up:		        Init environment.
up:
	export XDEBUG_MODE="develop"; docker-compose up -d

## debug: 	        Run the necessary services to run web with xdebug
debug:
	export XDEBUG_MODE="develop,debug,coverage"; docker-compose up -d

## down: 		        Down environment.
down:
	docker-compose down

## logs: 		        Show logs.
logs:
	docker-compose logs -f

## shell:                 Interactive shell to use commands inside docker
shell:
	docker-compose exec php bash

## cache:                  Clean symfony cache
cache:
	docker-compose run --rm php app/console cache:clear --env=dev
