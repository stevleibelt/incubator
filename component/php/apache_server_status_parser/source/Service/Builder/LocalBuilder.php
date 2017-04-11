<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-10
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\FileFetcher;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Processor\Processor;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\DetailOnlyStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\FullStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\StorageInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine\SectionStateMachine;
use RuntimeException;

class LocalBuilder implements BuilderInterface
{
    const PARSE_MODE_ALL            = 'all';
    const PARSE_MODE_DETAIL_ONLY    = 'detail_only';

    /** @var FileFetcher */
    private $fetcher;

    /** @var string */
    private $filePath;

    /** @var string */
    private $selectedParseMode;

    /** @var Processor */
    private $processor;

    public function __construct()
    {
        //begin of dependencies
        $this->fetcher  = new FileFetcher();
        //end of dependencies
    }

    public function selectParseModeAllUpfront()
    {
        $this->selectedParseMode = self::PARSE_MODE_ALL;
    }

    public function selectParseModeDetailOnlyUpfront()
    {
        $this->selectedParseMode = self::PARSE_MODE_DETAIL_ONLY;
    }

    /**
     * @param string $filePath
     */
    public function setPathToTheApacheStatusFileToParseUpfront($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @throws RuntimeException
     */
    public function build()
    {
        //begin of dependencies
        $fetcher        = $this->fetcher;
        $filePath       = $this->filePath;

        $stateMachine   = new SectionStateMachine();
        $stringUtility  = new StringUtility();
        //end of dependencies

        //begin of business logic
        if ($this->isParseModeAllSelected()) {
            $storage    = new FullStorage(
                $stringUtility
            );
        } else if ($this->isParseModeDetailOnly()) {
            $storage    = new DetailOnlyStorage(
                $stringUtility
            );
        } else {
            throw new RuntimeException(
                'no parse mode set'
            );
        }

        $processor      = new Processor(
            $stateMachine,
            $stringUtility,
            $storage
        );

        $fetcher->setPath($filePath);

        foreach ($fetcher->fetch() as $line) {
            $processor->process($line);
        }

        $this->processor = $processor;
        //end of business logic
    }

    /**
     * @return StorageInterface
     */
    public function andGetStorage()
    {
        return $this->processor->getStorage();
    }

    /**
     * @return bool
     */
    private function isParseModeAllSelected()
    {
        return ($this->selectedParseMode === self::PARSE_MODE_ALL);
    }

    /**
     * @return bool
     */
    private function isParseModeDetailOnly()
    {
        return ($this->selectedParseMode === self::PARSE_MODE_DETAIL_ONLY);
    }
}