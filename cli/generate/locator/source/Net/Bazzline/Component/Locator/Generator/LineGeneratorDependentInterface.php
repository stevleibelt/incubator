<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-22 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Interface LineGeneratorDependentInterface
 * @package Net\Bazzline\Component\Locator\Generator
 */
interface LineGeneratorDependentInterface
{
    /**
     * @param LineGenerator $generator
     * @return $this
     */
    public function setLineGenerator(LineGenerator $generator);
} 