<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-10
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\FetcherInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\FileFetcher;

class LocalBuilder extends AbstractBuilder
{
    /** @var FileFetcher */
    private $fetcher;

    /** @var string */
    private $filePath;

    public function __construct()
    {
        //begin of dependencies
        $this->fetcher = new FileFetcher();
        //end of dependencies
    }

    /**
     * @param string $filePath
     */
    public function setPathToTheApacheStatusFileToParseUpfront($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return FetcherInterface
     */
    protected function buildFetcher()
    {
        //begin of dependencies
        $fetcher    = $this->fetcher;
        $filePath   = $this->filePath;
        //end of dependencies

        //begin of business logic
        $fetcher->setPath($filePath);

        return $fetcher;
        //end of business logic
    }
}
