<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher;

use Net\Bazzline\Component\GenericAgreement\Exception\Runtime;
use RuntimeException;

class FileFetcher implements FetcherInterface
{
    /** @var string */
    private $path;

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return array
     * @throws RuntimeException
     */
    public function fetch()
    {
        //begin of dependencies
        $path   = $this->path;
        //end of dependencies

        //begin of business logic
        if (!is_readable($path)) {
            throw new Runtime(
                'provided path "' . $path . '" is not readable.'
            );
        }

        $contentAsString        = strip_tags(file_get_contents($path));
        $contentAsArray         = explode(PHP_EOL, $contentAsString);

        $lines = array_filter(
            $contentAsArray,
            function ($item) {
                return (strlen(trim($item)) > 0);
            }
        );

        return $lines;
        //end of business logic
    }
}