# Zend Framework 2 Module for the Locator Generator Component

This free as in freedom module should easy up the usage of the [locator generator component](https://github.com/bazzline/php_component_locator_generator) in the [zend framework 2](http://framework.zend.com/) in a zend framework 2 application.

It is based on the [skeleton zf2 module](https://github.com/zendframework/ZendSkeletonModule) and [phly_contact](https://github.com/weierophinney/phly_contact).
Thanks also to the [skeleton application](https://github.com/zendframework/ZendSkeletonApplication).

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/zf_locator_generator.png?branch=master)](http://travis-ci.org/bazzline/zf_locator_generator)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/zf_locator_generator.svg)](https://packagist.org/packages/net_bazzline/zf_locator_generator)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/) | [![build status](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/)

The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/540cac63ccc023c5e0000009/badge.svg?style=flat)](https://www.versioneye.com/user/projects/540cac63ccc023c5e0000009)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_locator_generator.svg)](https://packagist.org/packages/net_bazzline/zf_locator_generator)

It is also available at [openhub.net](http://www.openhub.net/p/718964).

Check out the [demo environment](https://github.com/bazzline/zf_demo_environment) if you want to see it in action.

# Backport for Zend Framework 2.2 / Debian 6

There is a [backport](https://github.com/bazzline/zf_locator_generator_debian_6_backport) available for debian 6 and its zend framework 2.2 limiting php version.

# @todo Backport for Zend Framework 2.4 / Debian 7

There is a [backport](https://github.com/bazzline/zf_locator_generator_debian_7_backport) available for debian 7 and its zend framework 2.4 limiting php version.

# Example

```shell
# generate one locator
php public/index.php net_bazzline locator generate <locator_name>

# generate all available locators
php public/index.php net_bazzline locator generate

# list all available locators
php public/index.php net_bazzline locator list
```

# Install

## By Hand

    mkdir -p vendor/net_bazzline/zf_locator_generator
    cd vendor/net_bazzline/zf_locator_generator
    git clone https://github.com/bazzline/zf_locator_generator

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_locator_generator)

    "net_bazzline/zf_locator_generator": "dev-master"

# Usage

* adapt your application.config.php and add “ZfLocatorGenerator” into the “modules” section

```php
<?php
return array(
    'modules' => array(
        'Application',
        'ZfLocatorGenerator'
    ),
    //...
```

* use zflocatorgenerator.global.php.dist as base
* copy this file into your config/autoload directory
* open this file and adapt it to your needs
* depending on the locator configuration, add it as invokable or by using a factory to your service manager configuration

# Migration

* [1.0.1 to 1.1.0](https://github.com/bazzline/zf_locator_generator/blob/master/migration/1.0.1_to_1.1.0.md)

# History

* upcomming
    * @todo
        * moved documentation to [code.bazzline.net](https://code.bazzline.net)
    * removed document section
    * removed dead code in unit test
* [1.4.2](https://github.com/bazzline/zf_locator_generator/tree/1.4.2) - released at 04.07.2015
    * updated dependency
* [1.4.1](https://github.com/bazzline/zf_locator_generator/tree/1.4.1) - released at 05.06.2015
    * fixed broken unit test
    * updated dependency
* [1.4.0](https://github.com/bazzline/zf_locator_generator/tree/1.4.0) - released at 05.06.2015
    * implemented usage of the [GenerateControllerFactory](https://github.com/bazzline/zf_locator_generator/blob/master/src/ZfLocatorGenerator/Controller/Console/GenerateControllerFactory.php)
    * removed not working code coverage
    * updated dependencies ([locator generator version 2.0.0](https://github.com/bazzline/php_component_locator_generator))
* [1.3.4](https://github.com/bazzline/zf_locator_generator/tree/1.3.4) - released at 22.05.2015
    * updated dependencies
* [1.3.3](https://github.com/bazzline/zf_locator_generator/tree/1.3.3) - released at 08.02.2015
    * updated dependencies
* [1.3.2](https://github.com/bazzline/zf_locator_generator/tree/1.3.2) - released at 08.02.2015
    * updated dependencies
* [1.3.1](https://github.com/bazzline/zf_locator_generator/tree/1.3.1) - released at 08.02.2015
    * removed apigen dependency
* [1.3.0](https://github.com/bazzline/zf_locator_generator/tree/1.3.0) - released at 08.02.2015
    * fixed dependencie issue
* [1.2.0](https://github.com/bazzline/zf_locator_generator/tree/1.2.0) - released at 07.02.2015
    * added factory for controller creation
    * updated to [locator generator 1.4.0](https://github.com/bazzline/php_component_locator_generator/tree/1.4.0)
* [1.1.1](https://github.com/bazzline/zf_locator_generator/tree/1.1.1) - released at 22.12.2014
    * updated dependencies
    * added documentation @todo - add link
    * added migration
    * added link to debian 6 / zend framework 2.2 backport
    * updated php_component_locator_generator to version 1.3.0
* [1.1.0](https://github.com/bazzline/zf_locator_generator/tree/1.1.0) - released at 21.09.2014
    * prefixed console commands with "net_bazzline" to not pollute the available command environment
* [1.0.1](https://github.com/bazzline/zf_locator_generator/tree/1.0.1) - released at 13.09.2014
    * fixed links in readme
    * fixed namespace issue in test
    * added usage of [zf console helper](https://github.com/bazzline/zf_console_helper)
    * updated dependencies
    * updated usage
* [1.0.0](https://github.com/bazzline/zf_locator_generator/tree/1.0.0) - released at 07.09.2014
    * initial release

