<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;
use Net\Bazzline\Component\Locator\Generator\MethodGenerator;

/**
 * Class MethodGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class MethodGeneratorFactory extends AbstractDocumentedGeneratorFactory
{
    /**
     * @param Indention $indention
     * @param BlockGenerator $blockGenerator
     * @param LineGenerator $lineGenerator
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface
     */
    protected function getNewGenerator(Indention $indention, BlockGenerator $blockGenerator, LineGenerator $lineGenerator)
    {
        return new MethodGenerator($indention, $blockGenerator, $lineGenerator);
    }
}