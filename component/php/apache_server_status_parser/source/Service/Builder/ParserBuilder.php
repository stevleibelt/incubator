<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-11
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Detail;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Information;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Scoreboard;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Statistic;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\InformationListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\ScoreboardListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\StatisticListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\DetailOnlyStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\FullStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\StorageInterface;
use RuntimeException;

class ParserBuilder implements BuilderInterface
{
    /** @var DetailListOfLineParser */
    private $detailListOfLineParser;

    /** @var InformationListOfLineParser */
    private $informationListOfLineParser;

    /** @var null|Information */
    private $informationOrNull;

    /** @var Detail[] */
    private $listOfDetail;

    /** @var ScoreboardListOfLineParser */
    private $scoreboardListOfLineParser;

    /** @var null|Scoreboard */
    private $scoreboardOrNull;

    /** @var StatisticListOfLineParser */
    private $statisticListOfLineParser;

    /** @var null|Statistic */
    private $statisticOrNull;

    /** @var StorageInterface */
    private $storage;

    /**
     * ParserBuilder constructor.
     *
     * @param DetailListOfLineParser $detailListOfLineParser
     * @param InformationListOfLineParser $informationListOfLineParser
     * @param ScoreboardListOfLineParser $scoreboardListOfLineParser
     * @param StatisticListOfLineParser $statisticListOfLineParser
     */
    public function __construct(
        DetailListOfLineParser $detailListOfLineParser,
        InformationListOfLineParser $informationListOfLineParser,
        ScoreboardListOfLineParser $scoreboardListOfLineParser,
        StatisticListOfLineParser $statisticListOfLineParser
    )
    {
        $this->detailListOfLineParser       = $detailListOfLineParser;
        $this->informationListOfLineParser  = $informationListOfLineParser;
        $this->scoreboardListOfLineParser   = $scoreboardListOfLineParser;
        $this->statisticListOfLineParser    = $statisticListOfLineParser;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorageUpfront(StorageInterface $storage)
    {
        $this->storage  = $storage;
    }

    /**
     * @throws RuntimeException
     */
    public function build()
    {
        //begin of dependencies
        $detailListOfLineParser         = $this->detailListOfLineParser;
        $informationListOfLineParser    = $this->informationListOfLineParser;
        $informationOrNull              = null;
        $scoreboardListOfLineParser     = $this->scoreboardListOfLineParser;
        $scoreboardOrNull               = null;
        $statisticListOfLineParser      = $this->statisticListOfLineParser;
        $statisticOrNull                = null;
        $storage                        = $this->storage;
        //end of dependencies

        //begin of business logic
        $storageIsAnInstanceOfDetailOnlyStorage = ($storage instanceof DetailOnlyStorage);
        $storageIsAnInstanceOfFullStorage       = ($storage instanceof FullStorage);

        if ($storageIsAnInstanceOfDetailOnlyStorage) {
            $listOfDetail   = $detailListOfLineParser->parse($storage->getListOfDetail());
        } else if ($storageIsAnInstanceOfFullStorage) {
            $informationOrNull  = $informationListOfLineParser->parse(
                $storage->getListOfInformation()
            );
            $listOfDetail       = $detailListOfLineParser->parse(
                $storage->getListOfDetail()
            );
            $scoreboardOrNull   = $scoreboardListOfLineParser->parse(
                $storage->getListOfScoreboard()
            );
            $statisticOrNull    = $statisticListOfLineParser->parse(
                $storage->getListOfStatistic()
            );
        } else {
            throw new RuntimeException(
                'StorageInterface implementation of "'
                . get_class_methods($storage)
                . '" is not supported.'
            );
        }

        $this->informationOrNull    = $informationOrNull;
        $this->listOfDetail         = $listOfDetail;
        $this->scoreboardOrNull     = $scoreboardOrNull;
        $this->statisticOrNull      = $statisticOrNull;
        //end of business logic
    }

    /**
     * @return null|Information
     */
    public function andGetInformationOrNullAfterwards()
    {
        return $this->informationOrNull;
    }

    /**
     * @return Detail[]
     */
    public function andGetListOfDetailAfterwards()
    {
        return $this->listOfDetail;
    }

    /**
     * @return null|Scoreboard
     */
    public function andGetScoreboardOrNullAfterwards()
    {
        return $this->scoreboardOrNull;
    }

    /**
     * @return null|Statistic
     */
    public function andGetStatisticOrNullAfterwards()
    {
        return $this->statisticOrNull;
    }
}