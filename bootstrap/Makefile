PROJECT_ROOT := $(abspath $(lastword $(MAKEFILE_LIST))/..)
SERVICE_ROOT := $(PROJECT_ROOT)/custom
SERVICE_ALL := $(subst $(SERVICE_ROOT)/,,$(shell find $(SERVICE_ROOT) -maxdepth 1 -mindepth 1 -type d))

.PHONY: help list add remove example up down

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(lastword $(MAKEFILE_LIST)) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

list: ## View a list of services.
	@sed -n '/CUSTOM SERVICE LIST/,$$p' docker-compose.yml | sed -n '/^[[:space:]][[:space:]][[:alnum:]]*:$$/p'

add: ## Add a new service.
ifndef SERVICE_NAME
	$(eval SERVICE_NAME := $(shell read -p "Enter a service name: " REPLY; echo $$REPLY))
endif
ifndef SUB_PATH
	$(eval SUB_PATH := $(shell read -p "Enter sub path to check in HAProxy (ex: admin): " REPLY; echo $$REPLY))
endif
ifndef SERVICE_DIR
	$(eval SERVICE_DIR := ./custom/$(SERVICE_NAME))
endif
	@mkdir -p $(SERVICE_DIR)

	@cp docker-compose.yml docker-compose.yml.bak
	@sed -e "s|{SERVICE_NAME}|$(SERVICE_NAME)|g" -e "s|{SERVICE_DIR}|$(SERVICE_DIR)|g" template/docker-compose-service.yml.tpl \
	| sed $$'/CUSTOM SERVICE LIST/r/dev/stdin' docker-compose.yml.bak \
	> docker-compose.yml

	@cp haproxy/config/haproxy.cfg haproxy/config/haproxy.cfg.bak
	@sed -e "s|{SERVICE_NAME}|$(SERVICE_NAME)|g" -e "s|{SUB_PATH}|$(SUB_PATH)|g" template/haproxy-acl.cfg.tpl \
	| sed $$'/ACL LIST/r/dev/stdin' haproxy/config/haproxy.cfg.bak \
	> haproxy/config/haproxy.cfg.tmp
	@sed "s|{SERVICE_NAME}|$(SERVICE_NAME)|g" template/haproxy-backend.cfg.tpl \
	| sed $$'/BACKEND LIST/r/dev/stdin' haproxy/config/haproxy.cfg.tmp \
	> haproxy/config/haproxy.cfg ; rm haproxy/config/haproxy.cfg.tmp

	@echo "$(SERVICE_NAME) is added."

remove: ## Remove an existing service.
	$(eval SERVICE_NAME := $(shell read -p "Enter a service name: " REPLY; echo $$REPLY))
	@cp haproxy/config/haproxy.cfg haproxy/config/haproxy.cfg.bak
	@sed -e '/acl is_$(SERVICE_NAME)/{N;d;}' -e '/backend $(SERVICE_NAME)/{N;N;d;}' haproxy/config/haproxy.cfg.bak > haproxy/config/haproxy.cfg
	@cp docker-compose.yml docker-compose.yml.bak
	@sed '/$(SERVICE_NAME):/{N;N;N;N;N;N;N;N;N;N;N;N;d;}' docker-compose.yml.bak > docker-compose.yml
	@rm -rf custom/$(SERVICE_NAME)

	@echo "$(SERVICE_NAME) is Removed."

example:
	$(eval SERVICE_NAME := $(shell read -p "Enter a service name: " REPLY; echo $$REPLY))
	$(eval SERVICE_DIR := $(shell sed -n '/$(SERVICE_NAME):/{N;N;N;p;}' docker-compose.yml | sed -n 's/- \(.*\):\/var\/www\/html$$/\1/p' | sed 's/[[:space:]]//g'))
	@if [[ "$(SERVICE_DIR)" = "" ]]; then \
		echo "$(SERVICE_NAME) is not exist."; \
		exit 1; \
	fi
	@read -p "Example will be created at $(SERVICE_DIR). Confirm? (Y/n): " REPLY; echo $$REPLY
	@if [[ "$$REPLY" = "Y" ]]; then \
		rsync --progress -a example $(SERVICE_DIR) --exclude=example/vendor/; \
	else \
		echo canceled; \
		exit 1; \
	fi


up:
	docker-compose up

down:
	docker-compose down
