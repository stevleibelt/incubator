#!/bin/php
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-14 
 */

namespace Net\Bazzline\Component\Locator\Generator;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

$indention = new Indention();

$class = new ClassGenerator($indention);
$class->setDocumentation(new DocumentationGenerator($indention));
$class->setName('ExampleDTO');

$properties = array(
    array(
        'name' => 'foo',
        'typeHint' => null,
        'value' => 42
    ),
    array(
        'name' => 'foobar',
        'typeHint' => 'array',
        'value' => null
    ),
    array(
        'name' => 'bar',
        'typeHint' => 'Bar',
        'value' => null
    )
);

foreach ($properties as $value) {
    //---- begin of properties
    $property = new PropertyGenerator($indention);
    $property->setDocumentation(new DocumentationGenerator($indention));
    $property->setName($value['name']);
    if (!is_null($value['value'])) {
        $property->setValue('value');
    }
    $property->markAsPrivate();
    $property->setDocumentation(new DocumentationGenerator($indention));
    //---- end of properties

    //---- begin of getter methods
    $getterMethod = new MethodGenerator($indention);
    $getterMethod->setDocumentation(new DocumentationGenerator($indention));
    $getterMethod->setName('get' . ucfirst($value['name']));
    $getterMethod->addParameter($value['name'], null, $value['typeHint']);
    $getterMethod->setBody(array('$this->' . $value['name'] . ' = $' . $value['name'] . ';'), $value['typeHint']);
    //---- end of getter methods

    //---- begin of setter methods
    $setterMethod = new MethodGenerator($indention);
    $setterMethod->setDocumentation(new DocumentationGenerator($indention));
    $setterMethod->setName('get' . ucfirst($value['name']));
    $setterMethod->setBody(array('return $this->' . $value['name'] . ';'));
    //---- end of setter methods

    $class->addClassProperty($property);
    $class->addMethod($getterMethod);
    $class->addMethod($setterMethod);
}

echo 'generated content' . PHP_EOL;
echo '----' . PHP_EOL;
echo $class->generate() . PHP_EOL;
