<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\ConstantGenerator;

/**
 * Class ConstantGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class ConstantGeneratorFactory extends AbstractGeneratorFactory
{
    /**
     * This method is just there for type hinting
     * @return \Net\Bazzline\Component\Locator\Generator\ConstantGenerator
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
        return new ConstantGenerator();
    }
}