#!/bin/php
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-14 
 */

namespace Net\Bazzline\Component\Locator\Generator\Example;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

/**
 * Class DTOGenerator
 * @package Net\Bazzline\Component\Locator\Generator\Example
 */
class DTOGenerator extends AbstractExample
{
    /**
     * @return mixed
     */
    function demonstrate()
    {
        $indention = $this->getIndention();

        //---- begin of factories
        $classFactory = $this->getClassGeneratorFactory();
        $documentationFactory = $this->getDocumentationGeneratorFactory();
        $methodFactory = $this->getMethodGeneratorFactory();
        $propertyFactory = $this->getPropertyGeneratorFactory();

        $class = $classFactory->create($indention);
        $class->setDocumentation($documentationFactory->create($indention));
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
            $property = $propertyFactory->create($indention);
            $property->setDocumentation($documentationFactory->create($indention));
            $property->setName($value['name']);
            if (!is_null($value['value'])) {
                $property->setValue('value');
            }
            $property->markAsPrivate();
            $property->setDocumentation($documentationFactory->create($indention));
            //---- end of properties

            //---- begin of getter method
            $getterMethod = $methodFactory->create($indention);
            $getterMethod->setDocumentation($documentationFactory->create($indention));
            $getterMethod->setName('get' . ucfirst($value['name']));
            $getterMethod->setBody(array('$this->' . $value['name'] . ' = $' . $value['name'] . ';'), $value['typeHint']);
            //---- end of getter method

            //---- begin of setter method
            $setterMethod = $methodFactory->create($indention);
            $setterMethod->setDocumentation($documentationFactory->create($indention));
            $setterMethod->addParameter($value['name'], null, $value['typeHint']);
            $setterMethod->setName('set' . ucfirst($value['name']));
            $setterMethod->setBody(array('return $this->' . $value['name'] . ';'));
            //---- end of setter method

            $class->addClassProperty($property);
            $class->addMethod($getterMethod);
            $class->addMethod($setterMethod);
        }

        echo 'generated content' . PHP_EOL;
        echo '----' . PHP_EOL;
        echo $class->generate() . PHP_EOL;
    }
}

$example = new DTOGenerator();
$example->demonstrate();
