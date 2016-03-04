# Simple Cli Standard Streams Object Wrapper for PHP

This project aims to deliver an easy to use and free as in freedom object oriented php standard stream component.
It provides tiny objects wrapping STDERR, STDIN and STDOUT.


The build status of the current master branch is tracked by Travis CI:
@todo
[![Build Status](https://travis-ci.org/bazzline/php_component_cli_standard_streams.png?branch=master)](http://travis-ci.org/bazzline/php_component_cli_standard_streams)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_cli_standard_streams.svg)](https://packagist.org/packages/net_bazzline/php_component_cli_standard_streams)

The scrutinizer status are:
@todo
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_cli_standard_streams/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_cli_standard_streams/)

The versioneye status is:
@todo
[![Dependency Status](https://www.versioneye.com/user/projects/553941560b24225ef6000002/badge.svg?style=flat)](https://www.versioneye.com/user/projects/553941560b24225ef6000002)

@todo
Take a look on [openhub.net](https://www.openhub.net/p/php_component_cli_standard_streams).


# Example

## By using the shipped with factories

```php
//simple use the provided factories to either get an StandardStreamInstancePool or an InputOutput object
use Net\Bazzline\Component\Cli\StandardStreams\InputOutputFactory;

$factory    = new InputOutputFactory();
$io         = $factory->createNewInstance();

//write a line to the output
$io->writeLineToOutput('write something and hit enter');
$io->writeLineToOutput('    "foobar" is not allowed');

$line               = $io->readFromInput();
$lineContainsFoobar = ($line == 'foobar');

if ($lineContainsFoobar) {
    $io->writeLineToError('invalid content entered');
} else {
    $io->writeLineToOutput('you entered following content: "' . $content . '"');
}
```

## Executable Examples

* [Error my input](https://github.com/bazzline/php_component_cli_standard_streams/blob/master/example/error_my_input)
* [Output my input](https://github.com/bazzline/php_component_cli_standard_streams/blob/master/example/output_my_input)

# Install

## By Hand

    mkdir -p vendor/net_bazzline/php_component_cli_standard_streams
    cd vendor/net_bazzline/php_component_cli_standard_streams
    git clone https://github.com/bazzline/php_component_cli_standard_streams .

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_cli_standard_streams)

    composer require net_bazzline/php_component_cli_standard_streams:dev-master

## Other Components Available

* [phasty/Stream](https://github.com/phasty/Stream)
* [clue/php-stream-filter](https://github.com/clue/php-stream-filter)
* [Talesoft/tale-stream](https://github.com/Talesoft/tale-stream)

# History

* upcomming
    * answer the question if a pre- and post- hook system is usefull
        * implement pre- and post- hooks
* [0.1.0](https://github.com/bazzline/php_component_cli_standard_streams/tree/0.1.0) - released at 0x.03.2016
    * initial plumber release

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it. [Donate something](https://gratipay.com/~stevleibelt) if you love it :-].
