<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Test\Net\Bazzline\Component\BatchJob;

use Net\Bazzline\Component\BatchJob\Batch\Batch;
use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 * @package Test\Net\Bazzline\Component\BatchJob
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @return Batch
     */
    public function getNewBatch()
    {
        return new Batch();
    }
}