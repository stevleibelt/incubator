<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-22 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Interface BlockGeneratorDependentInterface
 * @package Net\Bazzline\Component\Locator\Generator
 */
interface BlockGeneratorDependentInterface
{
    /**
     * @param BlockGenerator $generator
     * @return $this
     */
    public function setBlockGenerator(BlockGenerator $generator);
} 