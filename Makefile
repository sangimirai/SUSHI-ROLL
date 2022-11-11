PWD = $(shell pwd)

all:

lint:
	docker run -v $(PWD):/app --rm ghcr.io/phpstan/phpstan analyse

.PHONY: all lint
