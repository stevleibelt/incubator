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
     * @var string
     */
    protected $className;

    /**
     * @param string $className
     * @todo or simple inject "instance object"?
     */
    public function setClassName($className)
    {
        if ((is_string($className))
            && (strlen($className) > 0)) {
            $this->className = $className;
        }
    }



    /**
     * @param BlockGenerator $body
     * @return BlockGenerator
     * @throws RuntimeException
     */
    public function build(BlockGenerator $body)
    {
        $this->assertMandatoryParameters(array('className'));

        $body->add('return new ' . $this->className . '();');

        return $body;
    }
}