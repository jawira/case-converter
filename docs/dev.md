Development notes
=================

Phing targets
-------------

[![Phing targets](./images/build.png "Phing targets")](./images/build.png)

- `$ phing setup`: Prepare project for development.
- `$ phing qa`: Run quality tests, use this before every commit.

Documentation
-------------

Documentation is built when a `release` is created.

To install mkdocs locally type:

[comment]: <> (https://stackoverflow.com/a/41352413/4345061)

```console
sudo -H pip install mkdocs
```

Using Phing behind a proxy
--------------------------

If you are developing behind a proxy, you have to set the environment 
variable `http_proxy`. This variable already is imported in `build.xml`, so you
have nothing to do.

Creating new convention
-----------------------

1. Create new Gluer class
2. Create new split car
3. Update `\Jawira\CaseConverter\Convert::analyse` if needed
4. Register into `\Jawira\CaseConverter\Convert::handleSplitterMethod`
5. Register into `\Jawira\CaseConverter\Convert::handleGluerMethod`
6. Update docblock `\Jawira\CaseConverter\Convert` to register new methods.
7. Update documentation

Railroad diagram
----------------

- <https://tabatkins.github.io/railroad-diagrams/generator.html>

Class diagrams
--------------

[![Phing targets](./images/uml-case-converter.png "CaseConverter namespace")](./images/uml-case-converter.png)

[![Phing targets](./images/uml-glue.png "Glue namespace")](./images/uml-glue.png)

[![Phing targets](./images/uml-split.png "Split namespace")](./images/uml-split.png)

[git-flow]: https://github.com/petervanderdoes/gitflow-avh
[Keep a changelog]: http://keepachangelog.com/en/1.0.0/
[mkdocs]: https://www.mkdocs.org/#installation
[mkdocs-material]: https://github.com/squidfunk/mkdocs-material
[pds/skeleton]: https://github.com/php-pds/skeleton
[Phive]: https://phar.io/
[Semantic Versioning]: http://semver.org/
[Composer]: https://getcomposer.org/
