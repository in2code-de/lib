## Show this help
help:
	echo "$(EMOJI_interrobang) Makefile version $(VERSION) help "
	echo ''
	echo 'About this help:'
	echo '  Commands are ${BLUE}blue${RESET}'
	echo '  Targets are ${YELLOW}yellow${RESET}'
	echo '  Descriptions are ${GREEN}green${RESET}'
	echo ''
	echo 'Usage:'
	echo '  ${BLUE}make${RESET} ${YELLOW}<target>${RESET}'
	echo ''
	echo 'Targets:'
	awk '/^[a-zA-Z\-\_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")+1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  ${YELLOW}%-${TARGET_MAX_CHAR_NUM}s${RESET} ${GREEN}%s${RESET}\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Stop all containers
stop:
	echo "$(EMOJI_stop) Shutting down"
	docker-compose stop
	sleep 0.4
	docker-compose down --remove-orphans

## Removes all containers and volumes
destroy: stop
	echo "$(EMOJI_litter) Removing the project"
	docker-compose down -v --remove-orphans

## Starts docker-compose up -d
start:
	echo "$(EMOJI_up) Starting the docker project"
	docker-compose up -d --build

## Starts composer-install
composer:
	echo "$(EMOJI_package) Running composer"
	docker-compose exec php composer $(ARGS)

## Starts composer-install
composer-install:
	echo "$(EMOJI_package) Installing composer dependencies"
	docker-compose exec php composer install

## Starts composer-install
composer-install-production:
	echo "$(EMOJI_package) Installing composer dependencies (without dev)"
	docker-compose exec php composer install --no-dev -ao

## Initialize everything git-related
init-git:
	echo "$(EMOJI_nutandbolt) Setting up git pre-commit hook"
	git config core.hooksPath .project/githooks

## Initialize the docker setup
init-docker:
	echo "$(EMOJI_rocket) Initializing docker environment"
	docker-compose pull
	docker-compose build --pull
	docker-compose up -d

## To start an existing project incl. rsync from fileadmin, uploads and database dump
install-project: init-git stop init-docker composer-install
	echo "---------------------"
	echo ""
	echo "The project is online $(EMOJI_thumbsup)"
	echo ""
	echo 'Stop the project with "make stop"'
	echo ""
	echo "---------------------"

## Log into the PHP container
login-php:
	echo "$(EMOJI_elephant) Logging into the PHP container"
	docker-compose exec php bash

## Switch to a git branch at rebuild the dev env
switch-branch:
	git checkout $(ARGS)
	rm -rf composer.lock vendor
	make install-project

merge-branch-into:
	BRANCH=$$(git branch --show-current) \
		&& git checkout $(ARGS) \
		&& git merge --no-commit $$BRANCH
	rm -rf composer.lock vendor
	make install-project
	docker-compose exec php composer qa-all
	git commit

# SETTINGS
TARGET_MAX_CHAR_NUM := 25
MAKEFLAGS += --silent
SHELL := /bin/bash
VERSION := 1.0.0
ARGS = $(filter-out $@,$(MAKECMDGOALS))

# COLORS
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
BLUE   := $(shell tput -Txterm setaf 4)
WHITE  := $(shell tput -Txterm setaf 7)
RESET  := $(shell tput -Txterm sgr0)

# EMOJIS (some are padded right with whitespace for text alignment)
EMOJI_litter := "🚮️"
EMOJI_interrobang := "⁉️ "
EMOJI_floppy_disk := "💾️"
EMOJI_dividers := "🗂️ "
EMOJI_up := "🆙️"
EMOJI_receive := "📥️"
EMOJI_robot := "🤖️"
EMOJI_stop := "🛑️"
EMOJI_package := "📦️"
EMOJI_secure := "🔐️"
EMOJI_explodinghead := "🤯️"
EMOJI_rocket := "🚀️"
EMOJI_plug := "🔌️"
EMOJI_leftright := "↔️ "
EMOJI_upright := "↗️ "
EMOJI_thumbsup := "👍️"
EMOJI_telescope := "🔭️"
EMOJI_monkey := "🐒️"
EMOJI_elephant := "🐘️"
EMOJI_dolphin := "🐬️"
EMOJI_helicopter := "🚁️"
EMOJI_broom := "🧹"
EMOJI_nutandbolt := "🔩"
EMOJI_controlknobs := "🎛️"
