# idea

* create the real class on demand / lazy or proxy factory on instance
* good if your are not sure your instance is needed but you have to inject it as dependency

# notes

* either use reflection or magic methods

# code

```php
/**
 * @see
 *  https://gist.github.com/Ocramius/4098721
 *  https://github.com/doctrine/common/pull/168
 *  https://gist.github.com/Ocramius/72f95cc0801b4e2cb568
 *  https://i.imgur.com/kfX8w.png
 *  https://github.com/zendframework/zf2/pull/4145
 *  http://framework.zend.com/manual/current/en/modules/zend.service-manager.delegator-factories.html
 *  https://secure.php.net/manual/en/language.oop5.magic.php
 * 
 * @todo
 *  what about __sleep() & __wakeup()
 *
 * methods starting with "__" to prevent naming collisions
 */
class LazyLoader
{
    /** Closure */
    public $__cloner;

    /** Closure */
    public $__initializer;

    /** @var bool */
    private $isInitialized = false;

    /** @object */
    private $object;

    /**
     * @param Closure $initializer
     */
    public function __setInitializer(Closure $initializer)
    {
        $this->__initializer = $initializer;
    }

    /**
     * @param Closure $cloner
     */
    public function __setCloner(Closure $cloner)
    {
        $this->__cloner = $cloner;
    }

    /**
     * @return bool
     */
    public function __isInitialized()
    {
        return $this->isInitialized;
    }

    public function __markAsInitialized()
    {
        $this->isInitialized = true;
    }

    public function __call($name, array $values)
    {
        return $this->__initializer->__call('__call()', array($name, $values));
    }

    public function __clone()
    {
        return $this->cloner->__invoke('__clone', array($this->__initializer->__invoke());  //?
    }

    public function __get($name)
    {
        return $this->__initializer->__invoke('__get()', array($name));
    }

    public function __set($name, $value)
    {
        return $this->__initializer->__invoke('__set()', array($name, $value));
    }
}
```

# types

* lazy loading
    * special marker is indicating thie object is loaded
    * on each methodcall, it is checked if the class is instantiated
* virtual proxy
    * same object as the real object
    * each time a method is called, proxy loads the real object and calls the method
* value holder
    * implements a method like getValue
    * instantiates the real object when getValue is called once
* ghost
    * a real object without data
    * first time a method is called, it loads all the data into its fields

# links

* https://ocramius.github.io/blog/zf2-and-symfony-service-proxies-with-doctrine-proxies/
* https://en.wikipedia.org/wiki/Proxy_pattern
* https://en.wikipedia.org/wiki/Lazy_initialization
* http://www.martinfowler.com/eaaCatalog/lazyLoad.html
* http://www.craftitonline.com/2012/11/lazy-load-services-and-do-not-inject-the-container-into-them/
* https://ocramius.github.io/blog/proxy-pattern-in-php/
* https://github.com/Ocramius/ProxyManager
* https://github.com/Ocramius/LazyMap
* https://dzone.com/articles/practical-php-patterns/practical-php-patterns-lazy
* https://github.com/zetis/DP_LazyLoadingFactoryRIP
* https://github.com/watoki/factory
* https://github.com/lytc/sloths
* http://www.w3programmers.com/lazy-initialization-design-patterns-in-php/
* https://stackoverflow.com/questions/15786317/redundant-getters-and-setters-in-lazy-loading-and-dependency-injection-pattern
