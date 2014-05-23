<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\ClassGenerator;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;

/**
 * Class ClassGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class ClassGeneratorFactory extends AbstractGeneratorFactory
{
    /**
     * This method is just there for type hinting
     * @return \Net\Bazzline\Component\Locator\Generator\ClassGenerator
     */
    public function create()
    {
        return parent::create();
    }

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface
     */
    protected function getGenerator()
    {
        return new ClassGenerator();
    }
}