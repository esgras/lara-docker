include .env

pname=${COMPOSE_PROJECT_NAME}
project=-p $(pname)
mysql_pass=${DB_PASSWORD}

start:
	@docker-compose -f docker-compose.yml $(project) up -d

stop:
	@docker-compose -f docker-compose.yml $(project) down

restart: stop start

ssh-nginx:
	@docker-compose exec nginx /bin/sh

ssh:
	@docker-compose exec -u www-data php /bin/bash

ssh-root:
	@docker-compose exec php /bin/bash

ssh-mysql:
	@docker-compose exec mysql /bin/bash

exec:
	@docker-compose exec -u www-data php $$cmd

exec-bash:
	@docker-compose exec -u www-data php bash -c "$(cmd)"

logs:
	@docker logs -f $(pname)_php

logs-nginx:
	@docker logs -f $(pname)_nginx

build:
	@docker-compose build

phpunit-test:
	@make prepare-db-for-test
	@make exec-bash cmd="./vendor/bin/phpunit -c phpunit.xml"

prepare-db-for-test:
	@docker-compose exec mysql mysql -u root -p$(mysql_pass) -e "DROP DATABASE IF EXISTS lara_testing"
	@docker-compose exec mysql mysqladmin -u root -p$(mysql_pass) create lara_testing
	@make exec cmd="php artisan migrate --env=testing"

composer-install:
	@make exec cmd="composer install --optimize-autoloader --no-interaction --no-progress"

create-mysql-db:
	@docker-compose exec mysql mysqladmin -u root -p$(mysql_pass) create lara_docker

migrate:
	@make exec cmd="php artisan migrate"
