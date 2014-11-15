<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Class WorkerListItem
 * @package component\php\batch_job
 */
class WorkerListItem
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $numberOfAcquiredItems;

    /**
     * @var int
     */
    private $currentTimestamp;

    /**
     * @return null|int
     */
    public function getCurrentTimestamp()
    {
        return $this->currentTimestamp;
    }

    /**
     * @param int $currentTimestamp
     */
    public function setCurrentTimestamp($currentTimestamp)
    {
        $this->currentTimestamp = (int) $currentTimestamp;
    }

    /**
     * @return null|int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null|int
     */
    public function getNumberOfAcquiredItems()
    {
        return $this->numberOfAcquiredItems;
    }

    /**
     * @param int $numberOfAcquiredItems
     */
    public function setNumberOfAcquiredItems($numberOfAcquiredItems)
    {
        $this->numberOfAcquiredItems = $numberOfAcquiredItems;
    }
}