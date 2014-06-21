<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-22 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

/**
 * Class FromArrayAssemblerFactory
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
class FromArrayAssemblerFactory extends AbstractAssemblerFactory
{
    /**
     * @return FromArrayAssembler|AbstractAssembler
     */
    function create()
    {
        $assembler = $this->addDefaultMethodBodyBuilder(new FromArrayAssembler());

        return $assembler;
    }
}