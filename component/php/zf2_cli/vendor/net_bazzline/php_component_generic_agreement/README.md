# Generic Agreement Component for PHP

This component contains all generic agreements in the [bazzline](http://www.bazzline.net) code base.

# Sections

* Generic
    * Exception
        * [InvalidArgument](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Exception/InvalidArgument.php)
        * [Runtime](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Exception/Runtime.php)
        * [Standard](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Exception/Standard.php)
* Process
    * [Executable](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Process/ExecutableInterface.php) - execute a process
* Data
    * [AssemblageInterface](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Data/AssemblageInterface.php) - put data together
    * [FilterableInterface](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Data/FilterableInterface.php) - silver data
    * [GeneratorInterface](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Data/GeneratorInterface.php) - create data from a source
    * [ModifiableInterface](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Data/ModifiableInterface.php) - add or remove data values
    * [TransformableInterface](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Data/TransformableInterface.php) - transform from one data type into an other
    * [ValidatorInterface](https://github.com/bazzline/php_component_generic_agreement/blob/master/source/Net/Bazzline/Component/GenericAgreement/Data/ValidatorInterface.php) - change existing data values

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_generic_agreement
cd vendor/net_bazzline/php_component_generic_agreement
git clone https://github.com/bazzline/php_component_generic_agreement .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_generic_agreement)

```
composer require net_bazzline/php_component_generic_agreement:dev-master
```

# Api

[API](http://bazzline.net/b6ce78f8809910ae91c63c914b6f200b958b1373/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add following exceptions: "Dependency", "Memory" and "Time"
        * add link to openhub
        * implement examples and add notes with "intentions" about the class or interface to easy up figuring out the "why and when to use" question
* [1.0.1](https://github.com/bazzline/php_component_generic_agreement/tree/1.0.0) - released at 05.07.2015
    * aligned data interfaces, now each one can throw an ExceptionInterface
* [1.0.0](https://github.com/bazzline/php_component_generic_agreement/tree/1.0.0) - released at 01.07.2015
    * initial release
