install:
	composer install
dump:
	composer dump-autoload
validate:
	composer validate
gd-plain:
	./bin/gendiff ./tests/fixtures/plain1.json ./tests/fixtures/plain2.json
gd-nested:
	./bin/gendiff ./tests/fixtures/nested1.json ./tests/fixtures/nested2.json
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
	composer exec --verbose phpstan -- --level=5 analyse src tests bin
test:
	composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec phpunit tests -- --coverage-clover build/logs/clover.xml