# Locator Generator

Inspired by an [php usergroup meetup](http://artodeto.bazzline.net/archives/525-Social-Human-Architecture-for-Beginners-and-the-Flip-Side-of-Dependency-Injection-PHPUGHH.html), I started thinking about this configured locators around the web (especially with their generic "->get('foo')" interfaces.
Thats why I this project should lead to an locator, that can be configured as known but will be generated like propel is doing it with their classes. The benefit is the working code completion on your ide and you can see what the locator is doing instead of hoping it.

# Configruation File Example

```php
return array(
    'class_name' => 'Locator',
    'file_name' => 'Locator.php',
    'namespace' => 'Application\Service',
    'parent_class_name' => 'BaseLocator',
    'shared_instance' => array(
        'CookieManager' => 'Application\Cookie\CookieManager',              //invokable instance, CookieManager can be created by using "$cookieManager = new CookieManager()"
        'Database'      => 'Application\Service\Factory\DatabaseFactory'    //a factory takes care of creating the Database, depending on the php doc return annotation, either a class or an interface will be added to the created php doc, the factory has to implement a provided LocatorDependentInterface
    ),
    'single_instance' => array(
        'Lock'      => 'Application\Service\Factory\LockFileFactory',
        'LockAlias' => 'Application\Service\Factory\LockFileFactory'        //the key defines how the "get"-Method will be named
    )
);
```

# Generated Locator Example Code

```php
<?php
/**
 * @author Net\Bazzline\Component\Locator\Generator
 * @since 2014-04-24
 */

use Application\Cookie\CookieManager;
use Application\Service\Factory\DatabaseFactory;
use Application\Service\Factory\LockFileFactory;

/**
 * Class Locator
 * @package Application\Service
 */
class Locator extends BaseLocator
{
    //@todo add map for "instance pooling hash key to class" that the BaseLocator can use.
    private $sharedInstancePool = array();

    /**
     * @return Application\Cookie\CookieManager
     */
    public function getCookieManager()
    {
        return $this->fetchFromInstancePool('Application\Cookie\CookieManager');
    }

    /**
     * @return Application\Database\DatabaseInterface
     */
    public function getDatabase()
    {
        return $this->fetchFromInstancePoolByFactory('Application\Service\Factory\DatabaseFactory');
    }

    /**
     * @return Application\Lock\LockInterface
     */
    public function getLock()
    {
        return $this->fetchFromFactory('Application\Service\Factory\LockFileFactory')->create();  //factory is stored in an instance pool
    }

    /**
     * @return Application\Lock\LockInterface
     */
    public function getLockAlias()
    {
        return $this->fetchFromFactory('Application\Service\Factory\LockFileFactory')->create();  //factory is stored in an instance pool
    }


}
```

The BaseLocator is taking care of the instance pooling.

# Thanks

* [php-generator](https://github.com/nette/php-generator)
* [simple-php-code-gen](https://github.com/gotohr/simple-php-code-gen)
* [cg-library](https://github.com/schmittjoh/cg-library)
* [sensio generator bundle](https://github.com/sensiolabs/SensioGeneratorBundle)
* [php-ide-stub-generator](https://github.com/racztiborzoltan/php-ide-stub-generator)
* [php-token-reflection](https://github.com/Andrewsville/PHP-Token-Reflection)
* [code-generator](https://github.com/Speicher210/CodeGenerator)