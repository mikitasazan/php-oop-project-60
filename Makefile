install:
	composer install

lint:
	composer exec phpcs -- --standard=PSR12 src tests
	composer exec phpstan analyse

lint-fix:
	composer exec phpcbf -- --standard=PSR12 src tests

test:
	composer exec phpunit tests

test-coverage:
	composer exec phpunit tests -- --coverage-clover build/logs/clover.xml

.PHONY: install lint lint-fix test test-coverage
