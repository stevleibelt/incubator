<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-10-09 
 */

namespace component\php\batch_job;

/**
 * Class Batch
 * @package component\php\batch_job
 */
class Batch
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $size;

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
     * @return null|array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return null|int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = (int) $size;
    }
}