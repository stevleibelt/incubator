<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-09 
 */

namespace Test\Net\Bazzline\Component\Locator;

use Mockery;
use Net\Bazzline\Component\Locator\Configuration;
use Net\Bazzline\Component\Locator\FileExistsStrategy\DeleteStrategy;
use Net\Bazzline\Component\Locator\FileExistsStrategy\SuffixWithCurrentTimestampStrategy;
use Net\Bazzline\Component\Locator\LocatorGenerator;
use Net\Bazzline\Component\Locator\LocatorGeneratorFactory;
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
        return new Configuration();
    }

    /**
     * @return LocatorGenerator
     */
    protected function getLocatorGenerator()
    {
        return new LocatorGenerator();
    }

    /**
     * @return LocatorGeneratorFactory
     */
    protected function getLocatorGeneratorFactory()
    {
        return new LocatorGeneratorFactory();
    }
    //----end of locator namespace

    //----begin of helper
    //----end of helper
}