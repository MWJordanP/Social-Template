social
======
Template use : [http://www.bootply.com/96266](http://www.bootply.com/96266)
# Social-Template
Installation
------------

Step 1: Download Social-Template using github

```bash
    $ git clone git@github.com:MWJordanP/Social-Template.git
```

Step 2: Composer install

```bash
    $ composer install
```

Step 3: Install asset link

```bash
    $ php bin/console assets:install --symlink web
```

Step 4: Create database && update shema

```bash
    $ php bin/console doctrine:database:create
    $ php bin/console doctrine:schema:update --force
```


Report issue or feature request
-------------------------------

Reporting bug and feature requests are tracked in the [Github issue tracker](https://github.com/MWJordanP/Social-Template/issues).