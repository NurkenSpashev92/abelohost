.DEFAULT_GOAL := help

DOCKER_COMP = docker compose
APP = $(DOCKER_COMP) exec ab_app
MYSQL = $(DOCKER_COMP) exec ab_mysql

.PHONY: help install build rebuild start stop restart destroy composer seed shell mysql logs

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-15s\033[0m %s\n", $$1, $$2}'

install: build start composer seed ## Build, start and install dependencies

.env: ## Create .env from .env.example
	cp .env.example .env

build: .env ## Build docker images
	$(DOCKER_COMP) build

rebuild: .env ## Build docker images without cache
	$(DOCKER_COMP) build --no-cache

start: .env ## Start all services
	$(DOCKER_COMP) up -d

stop: ## Stop all services
	$(DOCKER_COMP) stop

restart: stop start ## Restart all services

destroy: ## Remove containers, networks and volumes
	$(DOCKER_COMP) down --volumes --remove-orphans

composer: ## Run composer install inside ab_app
	$(APP) composer install

seed: ## Fill DB with test categories and posts (make seed POSTS=100)
	$(APP) php bin/seed.php $(POSTS)

shell: ## Open bash inside ab_app
	$(APP) bash

mysql: ## Open mysql client inside ab_mysql
	$(MYSQL) sh -c 'mysql -uroot -p"$$MYSQL_ROOT_PASSWORD" --default-character-set=utf8mb4 "$$MYSQL_DATABASE"'

logs: ## Follow logs of all services
	$(DOCKER_COMP) logs -f
