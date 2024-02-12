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
test:
	vendor/bin/phpunit --bootstrap src/Difference.php tests/DifferenceTest.php