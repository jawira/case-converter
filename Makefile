help:	## Help
	@grep -Eh '^[[:alnum:][:blank:]_-\.]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
.PHONY: help

clear:	## Clear project
	rm -f bin/phpunit bin/composer
.PHONY: clear

bin/phpunit:	## Install PHPUnit 6
	@mkdir -p bin
	@wget --no-verbose -O bin/phpunit https://phar.phpunit.de/phpunit-6.phar
	@chmod +x bin/phpunit
	bin/phpunit --version

bin/composer:	## Install Composer
	@mkdir -p bin
	@wget --no-verbose -O composer-setup.php https://getcomposer.org/installer
	@php composer-setup.php --install-dir=bin --filename=composer
	@rm -f composer-setup.php
	bin/composer --version
