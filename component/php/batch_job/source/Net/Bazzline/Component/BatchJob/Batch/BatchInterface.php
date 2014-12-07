<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-05 
 */

namespace Net\Bazzline\Component\BatchJob\Batch;

use ArrayAccess;
use Iterator;

/**
 * Interface BatchInterface
 * @package Net\Bazzline\Component\BatchJob\Batch
 */
interface BatchInterface extends ArrayAccess, Iterator
{
    /**
     * @return mixed
     */
    public function getIdentifier();

    /**
     * @return array
     */
    public function getIds();

    /**
     * @return int
     */
    public function getSize();

    /**
     * @param mixed $identifier
     * @return $this
     */
    public function setIdentifier($identifier);

    /**
     * @param array $ids
     * @return $this
     */
    public function setIds(array $ids);
}