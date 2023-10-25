#!/bin/bash

DOCKER_BE = preventools-be
UID = $(shell id -u)

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
	docker network create preventools-network || true
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	U_ID=${UID} docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install

copy-files: ## Creates a copy of .env and docker-compose.yml.dist file to use locally
	cp -n .env.dist .env || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n phpunit.yml.dist phpunit.yml || true

# Backend commands
composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

migrate-database: ## Runs the migrations
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate -n

migrate-database-tests: ## Runs the migrations
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate --env=test -n

load-fixtures-database-tests: ## Runs the migrations
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bin/console doctrine:fixtures:load --env=test -n

be-logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} tail -f var/log/dev.log
# End backend commands

ssh-be: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash
ssh-root: ## ssh's into the be container
	docker exec -it ${DOCKER_BE} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix tests --rules=@Symfony

generate-ssh-keys: ## Generates SSH keys for JWT library
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} mkdir -p config/jwt
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} openssl genrsa -passout pass:385575d5de21265084cff0be44ebeca9 -out config/jwt/private.pem -aes256 4096
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} openssl rsa -pubout -passin pass:385575d5de21265084cff0be44ebeca9 -in config/jwt/private.pem -out config/jwt/public.pem
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} chmod 644 config/jwt/private.pem

all-tests: ## Runs Unit and Functional tests
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bin/phpunit

#create-root-user: ## Runs Unit and Functional tests
#	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bin/console app:create-root-user

# Supervisor
supervisor: ## Run supervisor with defined config in docker/php/supervisor.conf
	U_ID=${UID} docker exec -dt -uroot ${DOCKER_BE} supervisord