<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-10-31
 */

class CronJob
{
    /** @var null|string */
    private $dependsOnSuccessfulExecutedId;

    /** @var string */
    private $id;

    /** @var null|string */
    private $preExecuteCommand;

    /** @var string */
    private $commandToExecute;

    /** @var null|string */
    private $postSuccessfulExecuteCommand;

    /** @var null|string */
    private $postErrorExecuteCommand;

    /** @var int */
    private $repeatingIntervalInSeconds;

    /**
     * @param string $id
     * @param string $commandToExecute
     * @param int $repeatingIntervalInSeconds
     * @param null|string $dependsOnSuccessfulExecutedId
     * @param null|string $preExecuteCommand
     * @param null|string $postSuccessfulExecuteCommand
     * @param null|string $postErrorExecuteCommand
     */
    public function __construct($id, $commandToExecute, $repeatingIntervalInSeconds, $dependsOnSuccessfulExecutedId, $preExecuteCommand, $postSuccessfulExecuteCommand, $postErrorExecuteCommand)
    {
        $this->commandToExecute                 = $commandToExecute;
        $this->dependsOnSuccessfulExecutedId    = $dependsOnSuccessfulExecutedId;
        $this->id                               = $id;
        $this->postErrorExecuteCommand          = $postErrorExecuteCommand;
        $this->postSuccessfulExecuteCommand     = $postSuccessfulExecuteCommand;
        $this->preExecuteCommand                = $preExecuteCommand;
        $this->repeatingIntervalInSeconds       = $repeatingIntervalInSeconds;
    }

    /**
     * @return string
     */
    public function commandToExecute()
    {
        return $this->commandToExecute;
    }

    /**
     * @return null|string
     */
    public function dependsOnSuccessfulExecutedId()
    {
        return $this->dependsOnSuccessfulExecutedId;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function postErrorExecuteCommand()
    {
        return $this->postSuccessfulExecuteCommand;
    }

    /**
     * @return null|string
     */
    public function postSuccessfulExecuteCommand()
    {
        return $this->postSuccessfulExecuteCommand;
    }

    /**
     * @return null|string
     */
    public function preExecuteCommand()
    {
        return $this->commandToExecute;
    }

    /**
     * @return int
     */
    public function repeatingIntervalInSeconds()
    {
        return $this->repeatingIntervalInSeconds;
    }
}



$listOfCronJobs = array(
    0 => array(
        depends_on_successful_executed_id
    )
);
