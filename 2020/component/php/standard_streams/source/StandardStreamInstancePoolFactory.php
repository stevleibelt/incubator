<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-03-01
 */
namespace Net\Bazzline\Component\Cli\StandardStreams;

class StandardStreamInstancePoolFactory extends AbstractFactory
{
    /**
     * @return StandardStreamInstancePool
     */
    public function createNewInstance()
    {
        $streams = new StandardStreamInstancePool(
            $this->createNewErrorInstance(),
            $this->createNewInputInstance(),
            $this->createNewOutputInstance()
        );

        return $streams;
    }
}
