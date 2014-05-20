<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;

/**
 * Class LineGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class LineGeneratorFactory implements ContentFactoryInterface
{
    /**
     * @param Indention $indention
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface|\Net\Bazzline\Component\Locator\Generator\LineGenerator
     */
    public function create(Indention $indention)
    {
        return new LineGenerator($indention);
    }
}