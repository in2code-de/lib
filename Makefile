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

## Install this project (required once after checkout)
install: .prepare .clean .install-githooks .build
	docker run --rm -v $(PWD):/app -v $(HOME)/.composer/cache:/tmp/composer/cache -v $(HOME)/.composer/auth.json:/tmp/composer/auth.json co-stack/lib:$(TAG) composer i

.prepare:
	[ -d "$$HOME/.composer/cache" ] || mkdir -p "$$HOME/.composer/cache"
	[ -f "$$HOME/.composer/auth.json" ] || echo "{}" > "$$HOME/.composer/auth.json"

.clean:
	[ ! -f "composer.lock" ] || rm "composer.lock"
	[ ! -d "vendor" ] || rm -rf "vendor"

.build:
	docker inspect co-stack/lib:$(TAG) > /dev/null || DOCKER_BUILDKIT=1 docker build --build-arg IMAGE=$(IMAGE) -f .project/docker/Dockerfile -t co-stack/lib:$(TAG) .

## Run all tests
test: .build
	docker run --rm -v $(PWD):/app co-stack/lib:$(TAG) composer run qa-all

## Run a bash in a docker environment
bash: .build
	docker run --rm -it -v $(PWD):/app -v $(HOME)/.composer/cache:/tmp/composer/cache -v $(HOME)/.composer/auth.json:/tmp/composer/auth.json co-stack/lib:$(TAG) bash

.install-githooks:
	git config core.hooksPath .project/githooks

## Switch to a git branch at rebuild the dev env
switch-branch:
	git checkout $(ARGS)
	rm -rf composer.lock vendor
	make install-project

merge-downstream:
	ON_HEAD=''; for BRANCH in $$(git branch -l 'php*' --format="%(refname)" --sort=-refname | cut -d'/' -f3); do \
		if [[ "$$ON_HEAD" -eq "" ]]; then \
			ON_HEAD='1'; \
			git checkout $$BRANCH; \
		else \
			MESSAGE="$$(git log -1 --pretty=%s)" \
			&& if [[ "$$MESSAGE" != "[BACKPORT]"* ]]; then MESSAGE="[BACKPORT]$$MESSAGE"; fi \
			&& CURRENT=$$(git branch --show-current) \
			&& git checkout $$BRANCH \
			&& git merge --verify -m "$$MESSAGE" $$CURRENT; \
		fi; \
	done

include .env

# SETTINGS
TARGET_MAX_CHAR_NUM := 25
#MAKEFLAGS += --silent
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
