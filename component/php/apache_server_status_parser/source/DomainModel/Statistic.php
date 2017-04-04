<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-04
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\DomainModel;

use DateTime;

class Statistic implements ReduceDataAbleToArrayInterface
{
    const REDUCED_DATA_TO_ARRAY_KEY_B_PER_SECOND                            = 'b_per_request';
    const REDUCED_DATA_TO_ARRAY_KEY_CPU_LOAD                                = 'cpu_load';
    const REDUCED_DATA_TO_ARRAY_KEY_CPU_USAGE                               = 'cpu_usage';
    const REDUCED_DATA_TO_ARRAY_KEY_CURRENT_TIME                            = 'current_time';
    const REDUCED_DATA_TO_ARRAY_KEY_IDLE_WORKERS                            = 'idle_workers';
    const REDUCED_DATA_TO_ARRAY_KEY_KB_PER_REQUEST                          = 'kb_per_request';
    const REDUCED_DATA_TO_ARRAY_KEY_PARENT_SERVER_CONFIGURATION_GENERATION  = 'parent_server_configuration_generation';
    const REDUCED_DATA_TO_ARRAY_KEY_PARENT_SERVER_MPM_GENERATION            = 'parent_server_mpm_generation';
    const REDUCED_DATA_TO_ARRAY_KEY_REQUESTS_CURRENTLY_BEING_PROCESSED      = 'requests_currently_being_processed';
    const REDUCED_DATA_TO_ARRAY_KEY_REQUESTS_PER_SECOND                     = 'requests_per_second';
    const REDUCED_DATA_TO_ARRAY_KEY_RESTART_TIME                            = 'restart_time';
    const REDUCED_DATA_TO_ARRAY_KEY_SERVER_LOAD                             = 'server_load';
    const REDUCED_DATA_TO_ARRAY_KEY_SERVER_UP_TIME                          = 'server_up_time';
    const REDUCED_DATA_TO_ARRAY_KEY_TOTAL_ACCESSES                          = 'total_accesses';
    const REDUCED_DATA_TO_ARRAY_KEY_TOTAL_TRAFFIC                           = 'total_traffic';

    /** @var int */
    private $pPerSecond;

    /** @var float */
    private $cpuLoad;

    /** @var string */
    private $cpuUsage;

    /** @var DateTime */
    private $currentTime;

    /** @var int */
    private $idleWorkers;

    /** @var float */
    private $kbPerRequest;

    /** @var int */
    private $parentServerConfigurationGeneration;

    /** @var int */
    private $parentServerMpmGeneration;

    /** @var int */
    private $requestCurrentlyBeingProcessed;

    /** @var int */
    private $requestPerSecond;

    /** @var DateTime */
    private $restartTime;

    /** @var string */
    private $serverLoad;

    /** @var string */
    private $serverUpTime;

    /** @var int */
    private $totalAccess;

    /** @var string */
    private $totalTraffic;

    public function __construct(
        $pPerSecond,
        $cpuLoad,
        $cpuUsage,
        DateTime $currentTime,
        $idleWorkers,
        $kbPerRequest,
        $parentServerConfigurationGeneration,
        $parentServerMpmGeneration,
        $requestCurrentlyBeingProcessed,
        $requestPerSecond,
        Datetime $restartTime,
        $serverLoad,
        $serverUpTime,
        $totalAccess,
        $totalTraffic
    )
    {
        $this->pPerSecond                           = $pPerSecond;
        $this->cpuLoad                              = $cpuLoad;
        $this->cpuUsage                             = $cpuUsage;
        $this->currentTime                          = $currentTime;
        $this->idleWorkers                          = $idleWorkers;
        $this->kbPerRequest                         = $kbPerRequest;
        $this->parentServerConfigurationGeneration  = $parentServerConfigurationGeneration;
        $this->parentServerMpmGeneration            = $parentServerMpmGeneration;
        $this->requestCurrentlyBeingProcessed       = $requestCurrentlyBeingProcessed;
        $this->requestPerSecond                     = $requestPerSecond;
        $this->restartTime                          = $restartTime;
        $this->serverLoad                           = $serverLoad;
        $this->serverUpTime                         = $serverUpTime;
        $this->totalAccess                          = $totalAccess;
        $this->totalTraffic                         = $totalTraffic;
    }

    /**
     * @return int
     */
    public function pPerSecond()
    {
        return $this->pPerSecond;
    }

    /**
     * @return float
     */
    public function cpuLoad()
    {
        return $this->cpuLoad;
    }

    /**
     * @return string
     */
    public function cpuUsage()
    {
        return $this->cpuUsage;
    }

    /**
     * @return DateTime
     */
    public function currentTime()
    {
        return $this->currentTime;
    }

    /**
     * @return int
     */
    public function idleWorkers()
    {
        return $this->idleWorkers;
    }

    /**
     * @return float
     */
    public function kbPerRequest()
    {
        return $this->kbPerRequest;
    }

    /**
     * @return int
     */
    public function parentServerConfigurationGeneration()
    {
        return $this->parentServerConfigurationGeneration;
    }

    /**
     * @return int
     */
    public function parentServerMpmGeneration()
    {
        return $this->parentServerMpmGeneration;
    }

    /**
     * @return int
     */
    public function requestCurrentlyBeingProcessed()
    {
        return $this->requestCurrentlyBeingProcessed;
    }

    /**
     * @return int
     */
    public function requestPerSecond()
    {
        return $this->requestPerSecond;
    }

    /**
     * @return DateTime
     */
    public function restartTime()
    {
        return $this->restartTime;
    }

    /**
     * @return string
     */
    public function serverLoad()
    {
        return $this->serverLoad;
    }

    /**
     * @return string
     */
    public function serverUpTime()
    {
        return $this->serverUpTime;
    }

    /**
     * @return int
     */
    public function totalAccess()
    {
        return $this->totalAccess;
    }

    /**
     * @return string
     */
    public function totalTraffic()
    {
        return $this->totalTraffic;
    }

    /**
     * @return array
     */
    public function reduceDataToArray()
    {
        return [
            self::REDUCED_DATA_TO_ARRAY_KEY_B_PER_SECOND                            => $this->kbPerRequest,
            self::REDUCED_DATA_TO_ARRAY_KEY_CPU_LOAD                                => $this->cpuLoad,
            self::REDUCED_DATA_TO_ARRAY_KEY_CPU_USAGE                               => $this->cpuUsage,
            self::REDUCED_DATA_TO_ARRAY_KEY_CURRENT_TIME                            => $this->currentTime,
            self::REDUCED_DATA_TO_ARRAY_KEY_IDLE_WORKERS                            => $this->idleWorkers,
            self::REDUCED_DATA_TO_ARRAY_KEY_KB_PER_REQUEST                          => $this->kbPerRequest,
            self::REDUCED_DATA_TO_ARRAY_KEY_PARENT_SERVER_CONFIGURATION_GENERATION  => $this->parentServerConfigurationGeneration,
            self::REDUCED_DATA_TO_ARRAY_KEY_PARENT_SERVER_MPM_GENERATION            => $this->parentServerMpmGeneration,
            self::REDUCED_DATA_TO_ARRAY_KEY_REQUESTS_CURRENTLY_BEING_PROCESSED      => $this->requestCurrentlyBeingProcessed,
            self::REDUCED_DATA_TO_ARRAY_KEY_REQUESTS_PER_SECOND                     => $this->requestPerSecond,
            self::REDUCED_DATA_TO_ARRAY_KEY_RESTART_TIME                            => $this->restartTime,
            self::REDUCED_DATA_TO_ARRAY_KEY_SERVER_LOAD                             => $this->serverLoad,
            self::REDUCED_DATA_TO_ARRAY_KEY_SERVER_UP_TIME                          => $this->serverUpTime,
            self::REDUCED_DATA_TO_ARRAY_KEY_TOTAL_ACCESSES                          => $this->totalAccess,
            self::REDUCED_DATA_TO_ARRAY_KEY_TOTAL_TRAFFIC                           => $this->totalTraffic
        ];
    }
}