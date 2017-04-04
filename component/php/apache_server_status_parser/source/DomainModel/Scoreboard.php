<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-04
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\DomainModel;

class Scoreboard implements ReduceDataAbleToArrayInterface
{
    const REDUCED_DATA_TO_ARRAY_KEY_LIST_OF_LEGEND  = 'legend';
    const REDUCED_DATA_TO_ARRAY_KEY_LIST_OF_PROCESS = 'process';

    /** @var array */
    private $listOfLegend;

    /** @var array */
    private $listOfProcess;

    public function __construct(
        array $listOfLegend,
        array $listOfProcess
    )
    {
        $this->listOfLegend     = $listOfLegend;
        $this->listOfProcess    = $listOfProcess;
    }

    /**
     * @return array
     */
    public function listOfLegend()
    {
        return $this->listOfLegend;
    }

    /**
     * @return array
     */
    public function listOfProcess()
    {
        return $this->listOfProcess;
    }

    /**
     * @return array
     *  [
     *      'legend'    : array,
     *      'process'   : array
     *  ]
     */
    public function reduceDataToArray()
    {
        return [
            self::REDUCED_DATA_TO_ARRAY_KEY_LIST_OF_LEGEND  => $this->listOfLegend,
            self::REDUCED_DATA_TO_ARRAY_KEY_LIST_OF_PROCESS => $this->listOfProcess
        ];
    }
}