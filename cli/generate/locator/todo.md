# ToDos

* add schema.xml for propel schemal with namespace
* add generated unittest
* write about file exists strategy
* add "verify" method to configuration that throws an error if not all mandatory parameters are set
* implement validation of used interface- or class names by adding "autoloader class path"
* implement instance pooling creation only if needed (at least one factory or at least on shared instance)
* take a look to [om builder](https://github.com/propelorm/Propel/blob/master/generator/lib/builder/om/OMBuilder.php) and [abstract command](https://github.com/propelorm/Propel2/blob/master/src/Propel/Generator/Command/AbstractCommand.php)

c && r data/* && php bin/generateFromArrayFile.php source/Net/Bazzline/Component/Locator/Example/ArrayConfiguration/configuration.php
