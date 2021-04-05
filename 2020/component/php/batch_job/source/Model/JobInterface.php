<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\BatchJob\Model;

use Exception;

interface JobInterface
{
    /**
     * @param CollectionInterface $collection
     * @throws Exception
     */
    public function execute(CollectionInterface $collection);
}