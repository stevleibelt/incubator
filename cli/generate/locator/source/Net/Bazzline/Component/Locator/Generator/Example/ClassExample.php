<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Example;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

/**
 * Class ClassExample
 * @package Net\Bazzline\Component\Locator\Generator\Example
 */
class ClassExample extends AbstractExample
{
    /**
     * @return mixed
     */
    function demonstrate()
    {
        //@todo add "return $this" to all addProperty methods of each generator
        $classFactory = $this->getClassGeneratorFactory();
        $constantFactory = $this->getConstantGeneratorFactory();
        $documentationFactory = $this->getDocumentationGeneratorFactory();
        $methodFactory = $this->getMethodGeneratorFactory();
        $propertyFactory = $this->getPropertyGeneratorFactory();
        $traitFactory = $this->getTraitGeneratorFactory();

        //@todo implement documentation
        $myConstant = $constantFactory->create();
        $myConstant->setName('MY_CONSTANT');
        $myConstant->setValue('foobar');

        $myProperty = $propertyFactory->create();
        $myProperty->setDocumentation($documentationFactory->create());
        $myProperty->markAsProtected();
        $myProperty->setName('myProperty');
        //@todo extend documentation with automatically type hint (default mixed)
        $myProperty->setValue('12345678.90');

        $myMethod = $methodFactory->create();
        $myMethod->setDocumentation($documentationFactory->create());
        //@todo add markAsAbstract
        $myMethod->markAsPublic();
        $myMethod->markAsFinal();
        $myMethod->setName('myMethod');

        $myTrait = $traitFactory->create();
        $myTrait->setDocumentation($documentationFactory->create());
        $myTrait->setName('myTrait');

        $classDocumentation = $documentationFactory->create();
        $classDocumentation->setVersion('0.8.15', 'available since 2014-05-24');
        $classDocumentation->setAuthor('stev leibelt', 'artodeto@bazzline.net');

        $myClass = $classFactory->create();
        $myClass->setDocumentation($classDocumentation);
        $myClass->setNamespace('My\Namespace');
        $myClass->setName('MyClass');
        $myClass->markAsFinal();
        //@todo extend documentation -> add use if "\" exists in extends and "isInSameNamespace" is false
        $myClass->addExtends('Foo\Bar');
        //@todo extend documentation -> add use if "\" exists in implements and "isInSameNamespace" is false
        $myClass->addImplements('Bar\Foo');
        $myClass->addConstant($myConstant);
        $myClass->addMethod($myMethod);
        $myClass->addProperty($myProperty);
        $myClass->addTrait($myTrait);

        echo $myClass->generate() . PHP_EOL;
    }
}

$example = new ClassExample();
$example->demonstrate();