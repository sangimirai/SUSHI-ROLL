PWD = $(shell pwd)
ENV_FILE = .env.sample

all:

up:
	docker compose --env-file $(ENV_FILE) up

lint:
	docker run -v $(PWD):/app --rm ghcr.io/phpstan/phpstan analyse

.PHONY: all up lint
