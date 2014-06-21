<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-22 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

/**
 * Interface AssemblerFactoryInterface
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
interface AssemblerFactoryInterface
{
    /**
     * @return AbstractAssembler
     */
    public function create();
}