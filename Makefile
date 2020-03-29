.PHONY: build deps composer composer-install composer-update finish start destroy testing command behat unit close-test console

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
current-date := $(date +%Y%m%d%H%M%S)

build: deps start

deps: composer-install

finish: close-test destroy

testing: behat unit


composer-install: CMD=install --ignore-platform-reqs
composer-update: CMD=update --ignore-platform-reqs
composer composer-install composer-update:
	docker run --rm --interactive --tty -v $(current-dir):/app composer $(CMD)


start: CMD=up -d --build
destroy: CMD=down
start destroy:
	docker-compose $(CMD)


behat: CMD=vendor/bin/behat
unit: CMD=vendor/bin/phpunit --configuration phpunit.xml
close-test: CMD=git archive -o technical-test-`date +%Y%m%d%H%M%S`.zip HEAD
command behat unit close-test:
	docker exec -ti php-sns-sqs-aws $(CMD)

console:
	docker exec -ti php-sns-sqs-aws bash -c "app/bin/console $(CMD)"


