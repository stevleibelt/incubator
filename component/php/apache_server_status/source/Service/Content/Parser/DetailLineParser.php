<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-26
 */

namespace Net\Bazzline\Component\ApacheServerStatus\Service\Content\Parser;

use InvalidArgumentException;
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatus\DomainModel\Detail;

class DetailLineParser implements LineParserInterface
{
    /** @var StringUtility */
    private $stringUtility;

    /**
     * DetailLineParser constructor.
     *
     * @param StringUtility $stringUtility
     */
    public function __construct(StringUtility $stringUtility)
    {
        $this->stringUtility    = $stringUtility;
    }

    /**
     * @param string $line
     * @return Detail
     * @throws InvalidArgumentException
     */
    public function parse($line)
    {
        //begin of dependencies
        $stringUtility  = $this->stringUtility;
        //end of dependencies

        //begin of business logic
        $lineAsArray = explode(' ', $line);

        $arrayIsInvalid = (count($lineAsArray) <= 18);

        if ($arrayIsInvalid) {
            throw new InvalidArgumentException(
                self::class . ' can not parse given line'
            );
        }

        $httpMethod = (
            $stringUtility->startsWith($lineAsArray[16], '{')
                ? substr($lineAsArray[16], 1)
                : $lineAsArray[16]
        );
        $uriPathWithQuery   = (
            $stringUtility->endsWith($lineAsArray[17], '}')
                ? substr($lineAsArray[17], -1)
                : $lineAsArray[17]
        );

        return new Detail(
            $httpMethod,
            $lineAsArray[15],
            $lineAsArray[2],
            $lineAsArray[4],
            (isset($lineAsArray[19]) ? $lineAsArray[19] : $lineAsArray[18]),
            $uriPathWithQuery
        );
        //end of business logic
    }
}