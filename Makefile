help:	## Help
	@grep -Eh '^[[:alnum:][:blank:]_-\.]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
.PHONY: help

clear:	## Clear project
	rm -f bin/phpunit bin/composer
.PHONY: clear

bin/phpunit:	## Unit testing framework - https://phpunit.de/
	@mkdir -p $(@D)
	@wget --no-verbose -O $@ https://phar.phpunit.de/phpunit-7.phar
	@chmod +x $@
	$@ --version

bin/phpdoc:	## PHP documentor - https://www.phpdoc.org/
	@mkdir -p $(@D)
	@wget --no-verbose -O $@ http://phpdoc.org/phpDocumentor.phar
	@chmod +x $@
	$@ --version

bin/composer:	## Dependency Manager - https://getcomposer.org/
	@mkdir -p $(@D)
	@wget --no-verbose -O composer-setup.php https://getcomposer.org/installer
	@php composer-setup.php --install-dir=$(@D) --filename=$(@F) --version=1.7.2
	@rm -f composer-setup.php
	@chmod +x $@
	$@ self-update
