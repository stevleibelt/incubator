# Zend Framework 2 Console Helper Module

[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/zf_console_helper.svg)](https://packagist.org/packages/net_bazzline/zf_console_helper)

This free as in freedom module should easy up implementing console commands supporting [POSIX Signal Handling](https://en.wikipedia.org/wiki/POSIX_signal).

Furthermore, there are some simple but useful methods implemented:
* getParameter($name)
* getRequest()
* hasBooleanParameter($shortName = '', $longName = '')
* hasParameter($name)
* throwExceptionIfNotCalledInsideAnCliEnvironment()

It is based on the [skeleton zf2 module](https://github.com/zendframework/ZendSkeletonModule).
Thanks also to the [skeleton application](https://github.com/zendframework/ZendSkeletonApplication).

Since it is an abstract Controller, there are no test available.

The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/540f69de9e16223a73000002/badge.svg?style=flat)](https://www.versioneye.com/user/projects/540f69de9e16223a73000002)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_console_helper.svg)](https://packagist.org/packages/net_bazzline/zf_console_helper)

It is also available at [openhub.net](http://www.openhub.net/p/719029).

Check out the [demo environment](https://github.com/bazzline/zf_demo_environment) if you want to see it in action.

# Backport for Zend Framework 2.2 / Debian 6

There is a [backport](https://github.com/bazzline/zf_console_helper_debian_6_backport) available for debian 6 and its zend framework 2.2 limiting php version.

# Example / Usage

```php
<?php

namespace MyModule\Controller\Console;

use Exception;
use ZfConsoleHelper\Controller\Console\AbstractConsoleController;

class GenerateController extends AbstractConsoleController
{
    public function indexAction()
    {
        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            $this->attachSignalHandler($this);

            //some example items
            //  simple think about a lot of items that indicates longer
            //  processing runtime
            $items = array('one', 'two', 'three', 'four');

            //use implemented method to react on signal handling
            $this->processItems(
                $items,             //big list of items
                $this,              //current object
                'processItem',      //method that should be called for each item
                $arguments = array( //additional arguments for method 'processItem' (if needed)
                    'foo',
                    'bar'
                )
            );
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * must be protected since it will be called from the parent
     *
     * @param string $item
     * @param string $stringOne
     * @param string $stringTwo
     */
    protected function processItem($item, $stringOne, $stringTwo)
    {
        $console = $this->getConsole();
        $console->writeLine(
            'this is item "' . $item .
            '" with string one "' . $stringOne . '"' .
            '" and string two "' . $stringTwo . '"'
        );
    }

    /**
     * @return boolean
     */
    private function beVerbose()
    {
        return $this->hasBooleanParameter('v', 'verbose');
    }
}
```

Code like above will output something like that.

```shell
this is item "one" with string one "foo"" and string two "bar"
this is item "two" with string one "foo"" and string two "bar"
this is item "three" with string one "foo"" and string two "bar"
this is item "four" with string one "foo"" and string two "bar"
```

# [AbstractConsoleControllerFactory](https://github.com/bazzline/zf_console_helper/blob/master/src/ZfConsoleHelper/Controller/Console/AbstractConsoleControllerFactory.php)

The Factory is a good base for your controller factory.
Use the method "transformIntoServiceManager" to transform your injected [ControllerManager](http://framework.zend.com/manual/current/en/modules/zend.mvc.services.html) into [ServiceManager](http://framework.zend.com/manual/current/en/modules/zend.service-manager.intro.html).

# Install

## By Hand

    mkdir -p vendor/net_bazzline/zf_console_helper
    cd vendor/net_bazzline/zf_console_helper
    git clone https://github.com/bazzline/zf_console_helper

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_console_helper)

    "net_bazzline/zf_console_helper": "dev-master"

# History

* upcomming
    *@todo
        * moved documentation to [code.bazzline.net](https://code.bazzline.net)
* [1.1.0](https://github.com/bazzline/zf_console_helper/tree/1.0.4) - released at 04.06.2015
    * added [AbstractConsoleControllerFactory](https://github.com/bazzline/zf_console_helper/blob/master/src/ZfConsoleHelper/Controller/Console/AbstractConsoleControllerFactory.php)
* [1.0.3](https://github.com/bazzline/zf_console_helper/tree/1.0.3) - released at 08.02.2015
    * removed apigen dependency
* [1.0.2](https://github.com/bazzline/zf_console_helper/tree/1.0.2) - released at 08.02.2015
    * added use statement into example
    * added link to demo environment
    * added link to debian 6 / zend framework 2.2 backport
    * added minimum version of zend framework 2 to 2.3.\* since AbstractConsoleController is mandatory
    * updated dependencies
* [1.0.1](https://github.com/bazzline/zf_console_helper/tree/1.0.1) - released at 10.09.2014
    * added example code output
    * added apigen
    * moved to usage of "Zend\Mvc\Controller\AbstractConsoleController"
* [1.0.0](https://github.com/bazzline/zf_console_helper/tree/1.0.0) - released at 09.09.2014
    * initial release
