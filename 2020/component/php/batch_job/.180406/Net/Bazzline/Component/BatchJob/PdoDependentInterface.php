<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Net\Bazzline\Component\BatchJob;

use PDO;

/**
 * Interface PdoDependentInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface PdoDependentInterface
{
    /**
     * @param PDO $pdo
     * @return $this
     */
    public function injectPdo(PDO $pdo);
} 