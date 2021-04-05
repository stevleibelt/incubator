<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob\Queue;

use Net\Bazzline\Component\BatchJob\PdoDependentInterface;
use PDO;

/**
 * Class PdoQueue
 * @package Net\Bazzline\Component\BatchJob\Queue
 */
class PdoQueue implements QueueInterface, PdoDependentInterface
{
    /** @var PDO */
    private $pdo;

    /**
     * @param PDO $pdo
     * @return $this
     */
    public function injectPdo(PDO $pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }


}