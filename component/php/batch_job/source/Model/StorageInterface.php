<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\BatchJob\Model;

interface StorageInterface
{
    public function acquire(Batch $batch) : bool;

    public function delete(Batch $batch) : bool;

    public function release(Batch $batch) : bool;

    public function get(Batch $batch) : CollectionInterface;
}