<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-22 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

/**
 * Class FromPropelSchemaXmlAssemblerFactory
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
class FromPropelSchemaXmlAssemblerFactory extends AbstractAssemblerFactory
{
    /**
     * @return FromPropelSchemaXmlAssembler|AbstractAssembler
     */
    function create()
    {
        $assembler = $this->addDefaultMethodBodyBuilder(new FromPropelSchemaXmlAssembler());

        return $assembler;
    }
}