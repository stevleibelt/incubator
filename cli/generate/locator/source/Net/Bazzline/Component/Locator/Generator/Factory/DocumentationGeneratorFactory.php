<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\DocumentationGenerator;

/**
 * Class DocumentationGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class DocumentationGeneratorFactory extends AbstractGeneratorFactory
{
    /**
     * This method is just there for type hinting
     * @return \Net\Bazzline\Component\Locator\Generator\DocumentationGenerator
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
        return new DocumentationGenerator();
    }
}