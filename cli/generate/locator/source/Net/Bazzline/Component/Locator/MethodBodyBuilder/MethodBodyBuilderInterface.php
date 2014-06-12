<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-12 
 */

namespace Net\Bazzline\Component\Locator\MethodBodyBuilder;

use Net\Bazzline\Component\CodeGenerator\BlockGenerator;

/**
 * Interface MethodBodyBuilderInterface
 * @package Net\Bazzline\Component\Locator\MethodBodyBuilder
 */
interface MethodBodyBuilderInterface
{
    /**
     * @param BlockGenerator $body
     * @return BlockGenerator
     * @throws RuntimeException
     */
    public function build(BlockGenerator $body);
} 