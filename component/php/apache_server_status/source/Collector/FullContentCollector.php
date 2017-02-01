<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Collector;

use Net\Bazzline\Component\ApacheServerStatus\Tool\StringTool;

class FullContentCollector implements ContentCollectorInterface
{
    /** @var null|int */
    private $currentIndexKeyForListOfDetail;

    /** @var array */
    private $listOfDetail;

    /** @var array */
    private $listOfInformation;

    /** @var array */
    private $listOfScoreboard;

    /** @var array */
    private $listOfStatistic;

    /** @var StringTool */
    private $stringTool;

    /**
     * ContentCollection constructor.
     *
     * @param StringTool $stringTool
     */
    public function __construct(StringTool $stringTool)
    {
        $this->clear();

        $this->stringTool   = $stringTool;
    }

    /**
     * @param string $line
     */
    public function addDetail($line)
    {
        $stringTool = $this->stringTool;

        if (is_null($this->currentIndexKeyForListOfDetail)) {
            ++$this->currentIndexKeyForListOfDetail;
        } else {
            if ($stringTool->startsWith($line, 'Server')) {
                ++$this->currentIndexKeyForListOfDetail;
            }
        }

        if (isset($this->listOfDetail[$this->currentIndexKeyForListOfDetail])) {
            $this->listOfDetail[$this->currentIndexKeyForListOfDetail] .= $line;
        } else {
            $this->listOfDetail[$this->currentIndexKeyForListOfDetail] = $line;
        }
    }

    /**
     * @param string $line
     */
    public function addInformation($line)
    {
        $this->listOfInformation[] = $line;
    }

    /**
     * @param string $line
     */
    public function addScoreboard($line)
    {
        $this->listOfScoreboard[] = $line;
    }

    /**
     * @param string $line
     */
    public function addStatistic($line)
    {
        $this->listOfStatistic[] = $line;
    }

    public function clear()
    {
        $this->currentIndexKeyForListOfDetail  = null;

        $this->listOfDetail         = [];
        $this->listOfInformation    = [];
        $this->listOfScoreboard     = [];
        $this->listOfStatistic      = [];
    }

    /**
     * @return array
     */
    public function getListOfDetail()
    {
        return $this->listOfDetail;
    }

    /**
     * @return array
     */
    public function getListOfInformation()
    {
        return $this->listOfInformation;
    }

    /**
     * @return array
     */
    public function getListOfScoreboard()
    {
        return $this->listOfScoreboard;
    }

    /**
     * @return array
     */
    public function getListOfStatistic()
    {
        return $this->listOfStatistic;
    }
}