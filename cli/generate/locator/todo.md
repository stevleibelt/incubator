# ToDos

* add FactoryInterface generation to locator generator since they are tightly connected (delete LocatorInterface and replace LocatorInterface in FactoryInterface with current Locator class name)
* add InvalidArgumentException creation to locator generator (if locator has a name space)
* add generated unittest
* add schema.xml for propel schemal with namespace
* implement validation of used interface- or class names by adding "autoloader class path"
* implement instance pooling creation on if needed
* take a look to [om builder](https://github.com/propelorm/Propel/blob/master/generator/lib/builder/om/OMBuilder.php) and [abstract command](https://github.com/propelorm/Propel2/blob/master/src/Propel/Generator/Command/AbstractCommand.php)
