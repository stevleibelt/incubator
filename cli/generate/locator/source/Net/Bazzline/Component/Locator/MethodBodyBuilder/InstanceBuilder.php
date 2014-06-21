<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-13 
 */

namespace Net\Bazzline\Component\Locator\MethodBodyBuilder;

use Net\Bazzline\Component\CodeGenerator\BlockGenerator;

/**
 * Class InstanceBuilder
 * @package Net\Bazzline\Component\Locator\MethodBodyBuilder
 */
class InstanceBuilder extends AbstractMethodBodyBuilder
{
    /**
     * @param BlockGenerator $body
     * @return BlockGenerator
     * @throws RuntimeException
     */
    public function build(BlockGenerator $body)
    {
        $this->assertMandatoryParameters();

        $body->add('return new ' . $this->instance->getClassName() . '();');

        return $body;
    }
}