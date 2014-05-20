<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\Indention;

/**
 * Interface ContentFactoryInterface
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
interface ContentFactoryInterface
{
    /**
     * @param Indention $indention
     * @return \Net\Bazzline\Component\Locator\Generator\GeneratorInterface
     */
    public function create(Indention $indention);
}