# Readline Component for PHP

This project aims to deliver an easy to use and free as in freedom php compontent for dealing with unix console readline and autocomplete php scripts.


The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_cli_readline.png?branch=master)](http://travis-ci.org/bazzline/php_component_cli_readline)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_cli_readline.svg)](https://packagist.org/packages/net_bazzline/php_component_cli_readline)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/) | [![build status](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/)

The versioneye status is:
[![Dependency Status](https://www.versioneye.com/user/projects/557492b1316137000d0000d0/badge.svg?style=flat)](https://www.versioneye.com/user/projects/557492b1316137000d0000d0)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_cli_readline).

# Benefits

* autocomplete support
* configuration as array
    * set array with possible autocomplete options
    * bind actions to specific autocomplete options
* easy up php's [readline](https://secure.php.net/manual/en/book.readline.php) implementation as seen [here](https://github.com/stevleibelt/examples/blob/master/php/cli/readline.php)

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_cli_readline
cd vendor/net_bazzline/php_component_cli_readline
git clone https://github.com/bazzline/php_component_cli_readline .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_cli_readline)

```
    composer require net_bazzline/php_component_cli_readline:dev-master
```

# API

[API](http://www.bazzline.net/55371e9f93dbdec83dc82730a5a73db5fc36272e/index.html) is available at [bazzline.net](http://www.bazzline.net).


# History

* upcomming
    * @todo
        * cover code with unit tests
        * add support to inject [arguments](https://github.com/bazzline/php_component_cli_arguments) instead of simple arguments
* [1.0.0](https://github.com/bazzline/php_component_csv/tree/1.0.0) - released at 05.07.2015
    * initial release

# Other Great Components

* [hoa\Readline](https://github.com/hoaproject/Console/blob/master/Readline/Readline.php)
* [php-readline-react](https://github.com/clue/php-readline-react/blob/master/src/Readline.php)

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it :-D.
