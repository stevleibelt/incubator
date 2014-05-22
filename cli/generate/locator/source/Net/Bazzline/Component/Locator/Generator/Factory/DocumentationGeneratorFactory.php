<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\DocumentationGenerator;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;

/**
 * Class DocumentationGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class DocumentationGeneratorFactory extends AbstractGeneratorFactory
{
    /**
     * @param Indention $indention
     * @param BlockGenerator $blockGenerator
     * @param LineGenerator $lineGenerator
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface
     */
    protected function getGenerator(Indention $indention, BlockGenerator $blockGenerator, LineGenerator $lineGenerator)
    {
        return new DocumentationGenerator($indention, $blockGenerator, $lineGenerator);
    }
}