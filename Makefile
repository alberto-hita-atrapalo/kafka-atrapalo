all: help

SHELL:=/bin/bash

.PHONY: help up debug down shell install logs test

help: Makefile
	@sed -n 's/^##//p' $<

## install: 	        Install packages.
install:
	docker-compose run --rm php composer install;
	docker-compose run --rm node npm install

## up:		        Init environment.
up:
	docker-compose up -d

## down: 		        Down environment.
down:
	docker-compose down

## logs: 		        Show logs.
logs:
	docker-compose logs -f

## shell:                 Interactive shell to use commands inside docker
shell:
	docker-compose exec php bash
