<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-10
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\FileFetcher;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Processor\Processor;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\FullStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\StorageInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine\SectionStateMachine;
use RuntimeException;

class LocalBuilder implements BuilderInterface
{
    /** @var DetailListOfLineParser */
    private $detailListOfLineParser;

    /** @var FileFetcher */
    private $fetcher;

    /** @var string */
    private $filePath;

    /** @var Processor */
    private $processor;

    public function __construct()
    {
        //begin of local dependencies
        $stateMachine   = new SectionStateMachine();
        $stringUtility  = new StringUtility();
        $storage        = new FullStorage($stringUtility);
        //end of local dependencies

        //begin of global dependencies
        $this->detailListOfLineParser   = new DetailListOfLineParser(
            new DetailLineParser(
                $stringUtility
            )
        );
        $this->fetcher                  = new FileFetcher();
        $this->processor                = new Processor(
            $stateMachine,
            $stringUtility,
            $storage
        );
        //end of global dependencies
    }

    /**
     * @param string $filePath
     */
    public function setPathToTheApacheStatusFileToParse($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @throws RuntimeException
     */
    public function build()
    {
        //begin of dependencies
        $fetcher    = $this->fetcher;
        $filePath   = $this->filePath;
        $processor  = $this->processor;
        //end of dependencies

        //begin of business logic
        $fetcher->setPath($filePath);
        $processor->getStorage()->clear();  //I've decided to put this into one line to ease up showing that the storage is tightly connected to the processor

        foreach ($fetcher->fetch() as $line) {
            $processor->process($line);
        }
        //end of business logic
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->processor->getStorage();
    }
}