install:
	composer install
dump:
	composer dump-autoload
validate:
	composer validate
gd:
	./bin/gendiff ./tests/file1.json ./tests/file2.json
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
	composer exec --verbose phpstan -- --level=5 analyse src tests bin
test:
	composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml