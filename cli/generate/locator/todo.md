# ToDos

* add schema.xml for propel schemal with namespace
* refactor Configuration based on ArrayConfiguration example
* add FactoryInterface generation to locator generator since they are tightly connected (delete LocatorInterface and replace LocatorInterface in FactoryInterface with current Locator class name)
* add InvalidArgumentException creation to locator generator (if locator has a name space)
* add instance pooling method generation to locator generator
* add generated unittest
* implement validation of used interface- or class names by adding "autoloader class path"
