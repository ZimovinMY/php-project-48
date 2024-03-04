install:
	composer install
dump:
	composer dump-autoload
validate:
	composer validate
gd-stylish:
	./bin/gendiff --format stylish ./tests/fixtures/file1.json ./tests/fixtures/file2.json
gd-plain:
	./bin/gendiff --format plain ./tests/fixtures/file1.json ./tests/fixtures/file2.json
gd-json:
	./bin/gendiff --format json ./tests/fixtures/file1.json ./tests/fixtures/file2.json
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
	composer exec --verbose phpstan -- --level=3 analyse src tests bin
test:
	composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec phpunit tests -- --coverage-clover build/logs/clover.xml