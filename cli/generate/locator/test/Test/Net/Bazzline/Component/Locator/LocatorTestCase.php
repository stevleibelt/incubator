<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-09 
 */

namespace Test\Net\Bazzline\Component\Locator;

use Mockery;
use Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\MethodGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory;
use Net\Bazzline\Component\Locator\Configuration;
use Net\Bazzline\Component\Locator\FactoryInterfaceGenerator;
use Net\Bazzline\Component\Locator\FileExistsStrategy\DeleteStrategy;
use Net\Bazzline\Component\Locator\FileExistsStrategy\SuffixWithCurrentTimestampStrategy;
use Net\Bazzline\Component\Locator\Generator;
use Net\Bazzline\Component\Locator\GeneratorFactory;
use Net\Bazzline\Component\Locator\InvalidArgumentExceptionGenerator;
use Net\Bazzline\Component\Locator\LocatorGenerator;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromFactoryInstancePoolBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromSharedInstancePoolBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromSharedInstancePoolOrCreateByFactoryBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\NewInstanceBuilder;
use PHPUnit_Framework_TestCase;

/**
 * Class LocatorTestCase
 * @package Test\Net\Bazzline\Component
 */
class LocatorTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    //----begin of configuration namespace
    /**
     * @return Configuration\Instance
     */
    public function getInstance()
    {
        return new Configuration\Instance();
    }

    /**
     * @return Configuration\Uses
     */
    public function getUses()
    {
        return new Configuration\Uses();
    }
    //----end of configuration namespace
    //----begin of configuration assembler namespace
    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\Locator\Configuration\Assembler\AbstractAssembler
     */
    public function getAbstractAssembler()
    {
        return Mockery::mock('Net\Bazzline\Component\Locator\Configuration\Assembler\AbstractAssembler');
    }

    /**
     * @return Configuration\Assembler\FromArrayAssembler
     */
    public function getFromArrayAssembler()
    {
        return new Configuration\Assembler\FromArrayAssembler();
    }

    /**
     * @return Configuration\Assembler\FromPropelSchemaXmlAssembler
     */
    public function getFromPropelSchemaXmlAssembler()
    {
        return new Configuration\Assembler\FromPropelSchemaXmlAssembler();
    }
    //----end of configuration assembler namespace

    //----begin of file exists strategy namespace
    /**
     * @return DeleteStrategy
     */
    public function getDeleteStrategy()
    {
        return new DeleteStrategy();
    }

    /**
     * @return SuffixWithCurrentTimestampStrategy
     */
    public function getSuffixWithCurrentTimestampStrategy()
    {
        return new SuffixWithCurrentTimestampStrategy();
    }
    //----end of file exists strategy namespace

    //----begin of locator namespace
    /**
     * @return Configuration
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();

        $configuration->setFetchFromFactoryInstancePoolBuilder($this->getFetchFromFactoryInstancePoolBuilder());
        $configuration->setFetchFromSharedInstancePoolBuilder($this->getFetchFromSharedInstancePoolBuilder());
        $configuration->setFetchFromSharedInstancePoolOrCreateByFactoryBuilder($this->getFetchFromSharedInstancePoolOrCreateByFactoryBuilder());
        $configuration->setInstance($this->getInstance());
        $configuration->setNewInstanceBuilder($this->getNewInstanceBuilder());
        $configuration->setUses($this->getUses());

        return $configuration;
    }

    /**
     * @return FactoryInterfaceGenerator
     */
    protected function getFactoryInterfaceGenerator()
    {
        return new FactoryInterfaceGenerator();
    }

    /**
     * @return InvalidArgumentExceptionGenerator
     */
    protected function getInvalidArgumentExceptionGenerator()
    {
        return new InvalidArgumentExceptionGenerator();
    }

    /**
     * @return Generator
     */
    protected function getGenerator()
    {
        return new Generator();
    }

    /**
     * @return GeneratorFactory
     */
    protected function getGeneratorFactory()
    {
        return new GeneratorFactory();
    }

    /**
     * @return LocatorGenerator
     */
    protected function getLocatorGenerator()
    {
        return new LocatorGenerator();
    }
    //----end of locator namespace

    //----begin of helper
    //----end of helper

    //----begin of generator factory
    /**
     * @return BlockGeneratorFactory
     */
    protected function getBlockGeneratorFactory()
    {
        return new BlockGeneratorFactory();
    }

    /**
     * @return ClassGeneratorFactory
     */
    protected function getClassGeneratorFactory()
    {
        return new ClassGeneratorFactory();
    }

    /**
     * @return DocumentationGeneratorFactory
     */
    protected function getDocumentationGeneratorFactory()
    {
        return new DocumentationGeneratorFactory();
    }

    /**
     * @return FileGeneratorFactory
     */
    protected function getFileGeneratorFactory()
    {
        return new FileGeneratorFactory();
    }

    /**
     * @return MethodGeneratorFactory
     */
    protected function getMethodGeneratorFactory()
    {
        return new MethodGeneratorFactory();
    }

    /**
     * @return PropertyGeneratorFactory
     */
    protected function getPropertyGeneratorFactory()
    {
        return new PropertyGeneratorFactory();
    }
    //----end of generator factory

    //----begin of MethodBodyBuilder
    /**
     * @return FetchFromFactoryInstancePoolBuilder
     */
    protected function getFetchFromFactoryInstancePoolBuilder()
    {
        return new FetchFromFactoryInstancePoolBuilder();
    }

    /**
     * @return FetchFromSharedInstancePoolBuilder
     */
    protected function getFetchFromSharedInstancePoolBuilder()
    {
        return new FetchFromSharedInstancePoolBuilder();
    }

    /**
     * @return FetchFromSharedInstancePoolOrCreateByFactoryBuilder
     */
    protected function getFetchFromSharedInstancePoolOrCreateByFactoryBuilder()
    {
        return new FetchFromSharedInstancePoolOrCreateByFactoryBuilder();
    }

    /**
     * @return NewInstanceBuilder
     */
    protected function getNewInstanceBuilder()
    {
        return new NewInstanceBuilder();
    }
    //----end of MethodBodyBuilder
}