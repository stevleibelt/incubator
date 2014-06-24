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

# Terms

* Assembler
    * implements the [AssemblerInterface](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/Configuration/Assembler/AssemblerInterface.php)
    * implements the way the [Configuration](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/Configuration.php) is filled with data
* MethodBodyBuilder
    * implements the [MethodBodyBuilderInterface](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/MethodBodyBuilder/MethodBodyBuilderInterface.php)
    * provides a way to extend a instance creation method body
    * provides a way to extend the method documentation
* FileExistsStrategy
    * implements the [FileExistsStrategyInterface](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/FileExistsStrategy/FileExistsStrategyInterface.php)
    * provides a way to deal with the fact a generated file exists already

# Good and Bad

## Good

* on way of calling the locator generator "php bin/generateLocator.php <path to configuration file>"
* highly configurable
    * each configuration file needs to be a simple php array
    * mandatory array keys are
        * assembler
        * file_exists_strategy
    * optional array key is
        * boostrap_file
    * rest of configuration is based on the given assembler
* shipped with two [assembler](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/Configuration/Assembler) implementations
    * FromArrayAssembler
        * mandatory array keys
            * class_name <string>
            * extends <array> (can be empty)
            * file_path <string>
            * instances <array> (can be empty)
            * implements <array> (can be empty)
            * namespace <string> (can be empty)
            * uses <array> (can be empty)
        * optional array keys
            * instances
                * alias <string>
                * is_factory <boolean>
                * is_shared <boolean>
                * method_body_builder <string>
            * method_prefix <string>
            * uses
                * alias <string>
    * FromPropelSchemaXmlAssembler
        * mandatory array keys
            * class_name <string>
            * extends <array> (can be empty)
            * file_path <string>
            * implements <array> (can be empty)
            * namespace <string> (can be empty)
            * path_to_schema_xml <string>
            * uses <array> (can be empty)
        * optional array keys
            * method_prefix
    * implement the [AssemblerInterface](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/Configuration/Assembler/AssemblerInterface.php) to write your own Assembler
* shipped with two file exists strategies
    * DeleteStrategy
        * SuffixWithCurrentTimestampStrategy
        * can be extended by implementing the "FileExistsStrategyInterface"
* assembler and file exists strategy are runtime variables
* uses separate [component](https://github.com/stevleibelt/php_component_code_generator) for php code generation
* took only a few hours to write the "FromPropelSchemaXmlAssembler"
* shipped with five [method body builder](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/source/Net/Bazzline/Component/Locator/MethodBodyBuilder/MethodBodyBuilderInterface.php) implementations
    * FetchFromFactoryInstancePoolBuilder used internally by the generated locator
    * FetchFromSharedInstancePoolBuilder used internally by the generated locator
    * FetchFromSharedInstancePoolOrCreateByFactoryBuilder used internally by the generated locator
    * NewInstanceBuilder used internally by the generated locator
    * PropelQueryCreateBuilder as an example to use your own method body builder
    * [ValidatedInstanceCreationBuilder](https://github.com/stevleibelt/incubator/blob/master/cli/generate/locator/example/ArrayConfiguration/ValidatedInstanceCreationBuilder.php) as an additional example how to use the power of the method body builder support to generate own instance creation code

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
