# Locator Generator

# Why

* don't like "serviceLocator->get('foo')" (inexplicit API) calls
* like the configurable approach of some service locators out there
* inspired by a [php usergroup](http://artodeto.bazzline.net/archives/525-Social-Human-Architecture-for-Beginners-and-the-Flip-Side-of-Dependency-Injection-PHPUGHH.html) presentation called "[the flipside of dependency injection](http://thephp.cc/dates/2014/phpughh/the-flip-side-of-dependency-injection)" i'Ve seen "i'm not alone"
* generated code is easy debug- and understandable (no magic inside)

# How

* a task specific configuration assembler creates a unified configuration object
* unified configuration object is injected into the locator generator
* the locator generator creates needed files
* a file exists strategy can take care how to deal with existing files

# Good and Bad

## Good

* on way of calling the locator generator "php bin/generateLocator.php <path to configuration file>"
* shipped with two configuration assemblers
    * FromArrayAssembler
        * FromPropelSchemaXmlAssembler
        * can be extended by implementing the "AssemblerInterface"
* shipped with two file exists strategies
    * DeleteStrategy
        * SuffixWithCurrentTimestampStrategy
        * can be extended by implementing the "FileExistsStrategyInterface"
* assembler and file exists strategy are runtime variables
* uses separate [component](https://github.com/stevleibelt/php_component_code_generator) for php code generation
* took only a few hours to write the "FromPropelSchemaXmlAssembler"

## Bad

* still an incubator project
* missing tests
* missing features
* relying on [beta component](https://github.com/stevleibelt/php_component_code_generator)

# Behaviour

* creates a FactoryInterface file
* creates a InvalidArgumentException if a namespace is given

# Example

## Array Configuration File

Take a Look to [configuration file](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/example/ArrayConfiguration/configuration.php).

### How To Create

```shell
cd <component root directory>
php bin/generateLocator.php example/ArrayConfiguration/configuration.php
ls data/
vim data/FromArrayConfigurationFileLocator.php
```

### Generated Code

```php
<?php
/**
 * @author Net\Bazzline\Component\Locator
 * @since 2014-06-07
 */

namespace Application\Service;

use My\OtherInterface as MyInterface;
use Application\Locator\BaseLocator as BaseLocator;

/**
 * Class FromArrayConfigurationFileLocator
 *
 * @package Application\Service
 */
class FromArrayConfigurationFileLocator extends BaseLocator implements \My\Full\QualifiedInterface, MyInterface
{
    /**
     * @var $factoryInstancePool
     */
    private $factoryInstancePool = array();

    /**
     * @var $sharedInstancePool
     */
    private $sharedInstancePool = array();

    /**
     * @return \Application\Model\ExampleUniqueInvokableInstance
     */
    public function getExampleUniqueInvokableInstance()
    {
        return new \Application\Model\ExampleUniqueInvokableInstance();
    }

    /**
     * @return \Application\Factory\ExampleUniqueFactorizedInstanceFactory
     */
    public function getExampleUniqueFactorizedInstance()
    {
        return $this->fetchFromFactoryInstancePool('\Application\Factory\ExampleUniqueFactorizedInstanceFactory')->create();
    }

    /**
     * @return \Application\Model\ExampleSharedInvokableInstance
     */
    public function getExampleSharedInvokableInstance()
    {
        return $this->fetchFromSharedInstancePool('\Application\Model\ExampleSharedInvokableInstance');
    }

    /**
     * @return \Application\Factory\ExampleSharedFactorizedInstanceFactory
     */
    public function getExampleSharedFactorizedInstance()
    {
        $className = '\Application\Factory\ExampleSharedFactorizedInstanceFactory';

        if ($this->isNotInSharedInstancePool($className)) {
            $factoryClassName = '\Application\Factory\ExampleSharedFactorizedInstanceFactory';
            $factory = $this->fetchFromFactoryInstancePool($factoryClassName);

            $this->addToSharedInstancePool($className, $factory->create());
        }

        return $this->fetchFromSharedInstancePool($className);
    }
    //... code for internal methods
}
```

The Locator is taking care of the instance pooling.
