<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-22 
 */

namespace Net\Bazzline\Component\Locator\Configuration\Assembler;

use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromFactoryInstancePoolBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromSharedInstancePoolBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\FetchFromSharedInstancePoolOrCreateByFactoryBuilder;
use Net\Bazzline\Component\Locator\MethodBodyBuilder\NewInstanceBuilder;

/**
 * Class AbstractAssemblerFactory
 * @package Net\Bazzline\Component\Locator\Configuration\Assembler
 */
abstract class AbstractAssemblerFactory implements AssemblerFactoryInterface
{
    /**
     * @param AbstractAssembler $assembler
     * @return AbstractAssembler
     */
    protected function addDefaultMethodBodyBuilder(AbstractAssembler $assembler)
    {
        $fetchFromFactoryInstancePoolBuilder = new FetchFromFactoryInstancePoolBuilder();
        $fetchFromSharedInstancePoolBuilder = new FetchFromSharedInstancePoolBuilder();
        $fetchFromSharedInstancePoolOrCreateByFactoryBuilder = new FetchFromSharedInstancePoolOrCreateByFactoryBuilder();
        $newInstanceBuilder = new NewInstanceBuilder();

        $assembler
            ->setFetchFromFactoryInstancePoolBuilder($fetchFromFactoryInstancePoolBuilder)
            ->setFetchFromSharedInstancePoolBuilder($fetchFromSharedInstancePoolBuilder)
            ->setFetchFromSharedInstancePoolOrCreateByFactoryBuilder($fetchFromSharedInstancePoolOrCreateByFactoryBuilder)
            ->setNewInstanceBuilder($newInstanceBuilder);

        return $assembler;
    }
}