Development
===========

Testing
-------

- Test all:

    ```bash
    $ phing qa
    ```

- PHPUnit:

    ```bash
    $ phing phpunit:run
    ```

- Behat:

    ```bash
    $ phing behat:run
    ```

- Php lint:

    ```bash
    $ phing php:lint
    ```

- Validate Composer:

    ```bash
    $ phing composer:validate
    ```

Using proxy with Phing
----------------------

To use a proxy to download composer, phing and phpunit, you have to set the
environment variable `http_proxy`.

Conventions
-----------

This project adheres to:

 * [Semantic Versioning](http://semver.org/)
 * [Keep a changelog](http://keepachangelog.com/en/1.0.0/)
 * [pds/skeleton](https://github.com/php-pds/skeleton)
