#!/usr/bin/make -f

.DEFAULT_GOAL := help
.ONESHELL:

UID = $(shell id -u)
GID = $(shell id -g)

cwd := $(shell pwd)
comma := ,

DOCKER_ROOT_DIR = $(cwd)/docker
PHP_SRC_DIR = $(cwd)/php
NEO4J_ROOT_DIR = $(cwd)/neo4j
TMP_DIR = $(cwd)/build-tmp

define run_in_workspace
	cd $(DOCKER_ROOT_DIR) && docker-compose exec -T --user www-data php-cli /bin/bash -c "cd /php && $(1)"
endef

define run_in_workspace_as_root
	cd $(DOCKER_ROOT_DIR) && docker-compose exec -T --user root php-cli /bin/bash -c "cd /php && $(1)"
endef

.PHONY: docker-start
docker-start: ## Start docker stack
	cd $(DOCKER_ROOT_DIR) && docker-compose up

.PHONY: composer-install
composer-install: ## Install PHP dependencies
ifeq ($(CI),true)
	@echo "Creating Composer cache folder on CI..."
	mkdir -p $(COMPOSER_HOME) && sudo chown -R $(shell id -u):$(shell id -g) $(COMPOSER_HOME)
endif
	docker run --rm -it --volume $(PHP_SRC_DIR):/app --user $(shell id -u):$(shell id -g) -v $(COMPOSER_HOME):/tmp composer install --ignore-platform-reqs --no-scripts

.PHONY: shell
shell: ## Run a shell in the php container as www-data user
	cd $(DOCKER_ROOT_DIR) && docker-compose exec -u www-data php-cli bash

.PHONY: cypher-shell
cypher-shell: ## Execute interactive cypher shell
	cd $(DOCKER_ROOT_DIR) && docker-compose exec neo4j bin/cypher-shell -u neo4j -ptest

neo4j-plugins: $(NEO4J_ROOT_DIR)/plugins/graphaware-server-community-all-3.5.11.54.jar $(NEO4J_ROOT_DIR)/plugins/graphaware-resttest-3.5.11.54.20.jar

 $(NEO4J_ROOT_DIR)/plugins/graphaware-server-community-all-3.5.11.54.jar:
	@echo "Downloading Graphaware Framework Plugin..."
	cd $(NEO4J_ROOT_DIR)/plugins/ && wget -O graphaware-server-community-all-3.5.11.54.jar https://products.graphaware.com/download/framework-server-community/graphaware-server-community-all-3.5.11.54.jar

$(NEO4J_ROOT_DIR)/plugins/graphaware-resttest-3.5.11.54.20.jar:
	@echo "Downloading Graphaware REST-Test Plugin..."
	cd $(NEO4J_ROOT_DIR)/plugins/ && wget -O graphaware-resttest-3.5.11.54.20.jar https://products.graphaware.com/download/resttest/graphaware-resttest-3.5.11.54.20.jar

.PHONY: northwind.load
northwind.load: ## Load Northwind RDB sample data
	curl http://data.neo4j.com/northwind/products.csv > $(PHP_SRC_DIR)/example/Northwind/_data/products.csv
	curl http://data.neo4j.com/northwind/categories.csv > $(PHP_SRC_DIR)/example/Northwind/_data/categories.csv
	curl http://data.neo4j.com/northwind/suppliers.csv > $(PHP_SRC_DIR)/example/Northwind/_data/suppliers.csv
	curl http://data.neo4j.com/northwind/customers.csv > $(PHP_SRC_DIR)/example/Northwind/_data/customers.csv
	curl http://data.neo4j.com/northwind/orders.csv > $(PHP_SRC_DIR)/example/Northwind/_data/orders.csv
	curl http://data.neo4j.com/northwind/order-details.csv > $(PHP_SRC_DIR)/example/Northwind/_data/order-details.csv

.PHONY: help
help: ## Show help
	@IFS=$$'\n' ; \
		help_lines=(`fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//'`); \
		for help_line in $${help_lines[@]}; do \
				IFS=$$'#' ; \
				help_split=($$help_line) ; \
				help_command=`echo $${help_split[0]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
				help_info=`echo $${help_split[2]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
				printf "  \033[32m%-15s\033[0m %s\n" $$help_command $$help_info ; \
		done