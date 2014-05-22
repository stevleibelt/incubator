<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\Indention;

/**
 * Class BlockGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
class BlockGeneratorFactory implements ContentFactoryInterface
{
    /**
     * @var LineGeneratorFactory
     */
    private $lineFactory;

    /**
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface|\Net\Bazzline\Component\Locator\Generator\BlockGenerator
     */
    public function create()
    {
        return new BlockGenerator($this->getLineFactory()->create(), $this->getNewIndention());
    }

    /**
     * @return LineGeneratorFactory
     */
    private function getLineFactory()
    {
        if (is_null($this->lineFactory)) {
            $this->lineFactory = new LineGeneratorFactory();
        }

        return $this->lineFactory;
    }

    /**
     * @return Indention
     */
    private function getNewIndention()
    {
        return new Indention();
    }
}