<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\BlockGenerator;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\LineGenerator;

/**
 * Class AbstractGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
abstract class AbstractGeneratorFactory implements ContentFactoryInterface
{
    /**
     * @var Indention
     */
    private $indention;

    /**
     * @param Indention $indention
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface
     */
    public function create(Indention $indention)
    {
        $this->indention = $indention;

        return $this->getNewGenerator(
            $this->indention,
            $this->getNewBlockGenerator($this->indention),
            $this->getNewLineGenerator($this->indention)
        );
    }

    /**
     * @param Indention $indention
     * @param BlockGenerator $blockGenerator
     * @param LineGenerator $lineGenerator
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface
     */
    abstract protected function getNewGenerator(Indention $indention, BlockGenerator $blockGenerator, LineGenerator $lineGenerator);

    /**
     * @param Indention $indention
     * @return BlockGenerator
     */
    final protected function getNewBlockGenerator(Indention $indention)
    {
        return new BlockGenerator($this->getNewLineGenerator($indention), $indention);
    }

    /**
     * @param Indention $indention
     * @return LineGenerator
     */
    final protected function getNewLineGenerator(Indention $indention)
    {
        return new LineGenerator($indention);
    }
}