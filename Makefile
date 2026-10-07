.DEFAULT_GOAL := help

DOCKER_COMP = docker compose
APP = $(DOCKER_COMP) exec ab_app
MYSQL = $(DOCKER_COMP) exec ab_mysql

.PHONY: help install build rebuild start stop restart destroy composer shell mysql logs

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-15s\033[0m %s\n", $$1, $$2}'

install: build start composer ## Build, start and install dependencies

build: ## Build docker images
	$(DOCKER_COMP) build

rebuild: ## Build docker images without cache
	$(DOCKER_COMP) build --no-cache

start: ## Start all services
	$(DOCKER_COMP) up -d

stop: ## Stop all services
	$(DOCKER_COMP) stop

restart: stop start ## Restart all services

destroy: ## Remove containers, networks and volumes
	$(DOCKER_COMP) down --volumes --remove-orphans

composer: ## Run composer install inside ab_app
	$(APP) composer install

shell: ## Open bash inside ab_app
	$(APP) bash

mysql: ## Open mysql client inside ab_mysql
	$(MYSQL) mysql -uroot -proot --default-character-set=utf8mb4 blog

logs: ## Follow logs of all services
	$(DOCKER_COMP) logs -f
