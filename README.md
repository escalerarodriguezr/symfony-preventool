# PREVENTOOL

## What is this?
PHP application using ***Domain-Driven Design (DDD)*** principles.\
Implemented with Symfony 6.1 and includes `Docker configuration`.

- Authentication system with Json Web Tokens (JWT) (https://github.com/lexik/LexikJWTAuthenticationBundle)

## Usage /app
- `make copy-files` to creates a copy of .env and docker-compose.yml.dist file to use locally
- `make build` to build the docker environment
- `make run` to spin up containers
- `make restart` to stop and start containers
- `make prepare` to install composer dependencies
- `make generate-ssh-keys` to generate JWT certificates
- `make migrate-database` to runs the migrations
- `make migrate-database-tests` to runs the database-tests migrations
- `make all-tests` to run the test suite
- `make ssh-be` to access the PHP container bash
- `make supervisor` Run supervisor with defined config in docker/php/supervisord.conf

## Usage /commands to generate the necessary initial installation data
- `make create-root-user` after installing create the first user with root role
## Stack:
- `NGINX 1.19` container
- `PHP 8.1.1 FPM` container
- `MariaDB 10.7.1` container + `volume`
- `rabbitmq:3-management-alpine` container
