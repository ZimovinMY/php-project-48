## Difference Calculator

### Hexlet tests and linter status:
[![Actions Status](https://github.com/ZimovinMY/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/ZimovinMY/php-project-48/actions)
<a href="https://codeclimate.com/github/ZimovinMY/php-project-48/maintainability"><img src="https://api.codeclimate.com/v1/badges/da62a524453974cec387/maintainability" /></a>
<a href="https://codeclimate.com/github/ZimovinMY/php-project-48/test_coverage"><img src="https://api.codeclimate.com/v1/badges/da62a524453974cec387/test_coverage" /></a>

## About

A difference calculator is a program that determines the difference between two data structures. This is a popular task, for which there are many online services, for example: http://www.jsondiff.com/. A similar mechanism is used when outputting tests or automatically tracking changes in configuration files.

### Utility features:

* Supports different input formats: yaml and json
* Generating a report in the form of plain text, stylish and json

## Requirements

* php 8.0+
* composer 2.6.5
* make 4.3

## Setup
 
```sh
$ git clone https://github.com/ZimovinMY/php-project-48.git
$ cd php-project-48
$ make install
```
## Launch the utility
### Usage:
* gendiff (-h|--help)
* gendiff (-v|--version)
* gendiff [--format <fmt>] <firstFile> <secondFile>
### Options:
* -h --help                     Show this screen
* -v --version                  Show version
* --format <fmt>                Report format [default: stylish]
## Launch PHP_CodeSniffer and PHPStan

```sh
$ make lint
```

## Asciinema recordings
<details>
<summary>1</summary>
<a href="https://asciinema.org/a/ME0ZCvr7Publc5jMvL9tQ1BbP" target="_blank"><img src="https://asciinema.org/a/ME0ZCvr7Publc5jMvL9tQ1BbP.svg" /></a>
</details>

<details>
<summary>2</summary>
<a href="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa" target="_blank"><img src="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa.svg" /></a>
</details>

<details>
<summary>3</summary>
<a href="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa" target="_blank"><img src="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa.svg" /></a>
</details>

<details>
<summary>4</summary>
<a href="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa" target="_blank"><img src="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa.svg" /></a>
</details>

<details>
<summary>5</summary>
<a href="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa" target="_blank"><img src="https://asciinema.org/a/tp1OY2MfZUGWcsbYJekeQmysa.svg" /></a>
</details>
