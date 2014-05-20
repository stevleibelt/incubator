<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Test\Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\ClassGenerator;
use Net\Bazzline\Component\Locator\Generator\ConstantGenerator;
use Net\Bazzline\Component\Locator\Generator\DocumentationGenerator;
use Net\Bazzline\Component\Locator\Generator\FileGenerator;
use Net\Bazzline\Component\Locator\Generator\GeneratorInterface;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;
use Net\Bazzline\Component\Locator\Generator\MethodGenerator;
use Net\Bazzline\Component\Locator\Generator\PropertyGenerator;
use Net\Bazzline\Component\Locator\Generator\TraitGenerator;
use PHPUnit_Framework_TestCase;
use Mockery;

/**
 * Class GeneratorTestCase
 * @package Test\Net\Bazzline\Component\Locator\Generator
 */
class GeneratorTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $factoryInstancePool = array();

    //----begin of general----
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return Indention
     */
    protected function getIndention()
    {
        return new Indention();
    }

    /**
     * @param string $fullQualifiedClassName
     * @return Mockery\MockInterface
     */
    protected function getMockeryMock($fullQualifiedClassName)
    {
        return Mockery::mock($fullQualifiedClassName);
    }

    /**
     * @param GeneratorInterface $generator
     */
    protected function debugGenerator(GeneratorInterface $generator)
    {
        echo PHP_EOL . '----' . PHP_EOL . $generator->generate() . PHP_EOL . '----' . PHP_EOL;
    }
    //----end of general----

    //----begin of generator----
    /**
     * @return BlockGenerator
     */
    protected function getBlockGenerator()
    {
        return $this->getBlockGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return ClassGenerator
     */
    protected function getClassGenerator()
    {
        return $this->getClassGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return ConstantGenerator
     */
    protected function getConstantGenerator()
    {
        return $this->getConstantGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return FileGenerator
     */
    protected function getFileGenerator()
    {
        return $this->getFileGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return LineGenerator
     */
    protected function getLineGenerator()
    {
        return $this->getLineGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return MethodGenerator
     */
    protected function getMethodGenerator()
    {
        return $this->getMethodGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return DocumentationGenerator
     */
    protected function getDocumentationGenerator()
    {
        return $this->getDocumentationGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return PropertyGenerator
     */
    protected function getPropertyGenerator()
    {
        return $this->getPropertyGeneratorFactory()->create($this->getIndention());
    }

    /**
     * @return TraitGenerator
     */
    protected function getTraitGenerator()
    {
        return $this->getTraitGeneratorFactory()->create($this->getIndention());
    }
    //----end of generator----

    //----begin of factory instance pool
    /**
     * @param $className
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\AbstractGeneratorFactory
     */
    private function getFactoryFromInstancePool($className)
    {
        $namespacedClassName = '\\Net\\Bazzline\\Component\\Locator\\Generator\\Factory\\' . $className;
        if (!isset($this->factoryInstancePool[$namespacedClassName])) {
            $this->factoryInstancePool[$namespacedClassName] = new $namespacedClassName();
        }

        return $this->factoryInstancePool[$namespacedClassName];
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\BlockGeneratorFactory
     */
    private function getBlockGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('BlockGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\PropertyGeneratorFactory
     */
    private function getPropertyGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('PropertyGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\ClassGeneratorFactory
     */
    private function getClassGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('ClassGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\ConstantGeneratorFactory
     */
    private function getConstantGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('ConstantGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\FileGeneratorFactory
     */
    private function getFileGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('FileGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\LineGeneratorFactory
     */
    private function getLineGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('LineGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\MethodGeneratorFactory
     */
    private function getMethodGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('MethodGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\DocumentationGeneratorFactory
     */
    private function getDocumentationGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('DocumentationGeneratorFactory');
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\Factory\TraitGeneratorFactory
     */
    private function getTraitGeneratorFactory()
    {
        return $this->getFactoryFromInstancePool('TraitGeneratorFactory');
    }
    //----end of factory instance pool
}