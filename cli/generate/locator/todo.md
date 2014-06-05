# ToDos

* refactor Configuration based on ArrayConfiguration example
* add instance pooling method generation to locator generator
* add FactoryInterface generation to locator generator since they are tightly connected (delete LocatorInterface and replace LocatorInterface in FactoryInterface with current Locator class name)
* add InvalidArgumentException creation to locator generator (if locator has a name space)
* add generated unittest
* add schema.xml for propel schemal with namespace
* implement validation of used interface- or class names by adding "autoloader class path"
* implement instance pooling creation on if needed
