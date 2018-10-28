#!/usr/bin/env bash

install: drop_database create_database running_migrations running_fixtures
drop_database:
	@echo "Deleting database for fresh install..."
	php bin/console doctrine:database:drop --force --if-exists
create_database:
	@echo "Creating Database if doesn't exists..."
	php bin/console doctrine:database:create --if-not-exists
running_migrations:
	@echo "Updating database structure..."
	php bin/console doctrine:migrations:migrate -n
running_fixtures:
	@echo "Inserting seed data into database (fixtures)..."
	php bin/console doctrine:fixtures:load -n
