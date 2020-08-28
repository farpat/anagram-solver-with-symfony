.PHONY: install update clean help test dusk dev stop-dev build migrate bash
.DEFAULT_GOAL   = help

include .env

PRIMARY_COLOR   		= \033[0;34m
PRIMARY_COLOR_BOLD   	= \033[1;34m

SUCCESS_COLOR   		= \033[0;32m
SUCCESS_COLOR_BOLD   	= \033[1;32m

DANGER_COLOR    		= \033[0;31m
DANGER_COLOR_BOLD    	= \033[1;31m

WARNING_COLOR   		= \033[0;33m
WARNING_COLOR_BOLD   	= \033[1;33m

NO_COLOR      			= \033[m

# For test
filter      ?= tests
dir         ?=

php := docker-compose run --rm php php
bash := docker-compose run --rm php bash
composer := docker-compose run --rm php composer
npm := npm

node_modules: package.json
	@echo "Installing: $(PRIMARY_COLOR_BOLD)composer$(NO_COLOR) dependencies..."
	@$(npm) install

vendor: composer.json
	@echo "Installing: $(PRIMARY_COLOR_BOLD)composer$(NO_COLOR) dependencies..."
	@$(composer) install

install: vendor node_modules ## Install the composer dependencies and npm dependencies

update: ## Update the composer dependencies and npm dependencies
	@$(composer) update
	@$(npm) run update
	@$(npm) install

help: ## Display this help
	@awk 'BEGIN {FS = ":.*##"; } /^[a-zA-Z_-]+:.*?##/ { printf "$(PRIMARY_COLOR_BOLD)%-10s$(NO_COLOR) %s\n", $$1, $$2 }' $(MAKEFILE_LIST) | sort

test: install ## Run unit tests (parameters : dir=tests/Feature/LoginTest.php || filter=get)
	@$(php) bin/phpunit $(dir) --filter $(filter) --testdox

dev: install ## Run development servers
	@docker-compose up -d
	@echo "Nginx server launched on http://localhost:8080"
	@echo "Webpack dev server launched on http://localhost:3000"

stop-dev: ## Stop development servers
	@docker-compose down
	@echo "Nginx server stopped: http://localhost:8080"
	@echo "Webpack dev server stopped: http://localhost:3000"

build: install ## Build assets projects for production
	@rm -rf ./public/assets/*
	@$(npm) run build

bash: ## Run bash in PHP container
	@$(bash)
