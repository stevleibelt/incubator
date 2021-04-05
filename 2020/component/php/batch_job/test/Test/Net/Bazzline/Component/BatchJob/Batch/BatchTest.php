<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-12-06 
 */

namespace Test\Net\Bazzline\Component\BatchJob\Batch;

use Test\Net\Bazzline\Component\BatchJob\TestCase;

/**
 * Class BatchTest
 * @package Test\Net\Bazzline\Component\BatchJob
 */
class BatchTest extends TestCase
{
    public function testBatchInterfaceImplementation()
    {
        $batch = $this->getNewBatch();
        $identifier = __LINE__;
        $ids = array(
            __LINE__,
            __LINE__,
            __LINE__
        );

        $this->assertNull($batch->getIdentifier());
        $this->assertEmpty($batch->getIds());
        $this->assertEquals(0, $batch->getSize());

        $this->assertEquals($batch, $batch->setIdentifier($identifier));
        $this->assertEquals($batch, $batch->setIds($ids));

        $this->assertEquals($identifier, $batch->getIdentifier());
        $this->assertEquals($ids, $batch->getIds());
        $this->assertEquals(count($ids), $batch->getSize());
    }

    public function testArrayAccessImplementation()
    {
        $batch = $this->getNewBatch();
        $ids = array(
            __LINE__,
            __LINE__,
            __LINE__
        );

        foreach ($ids as $key => $value) {
            $this->assertFalse($batch->offsetExists($key));
            $batch->offsetSet($key, $value);
        }

        foreach ($ids as $key => $value) {
            $this->assertTrue($batch->offsetExists($key));
            $this->assertEquals($value, $batch->offsetGet($key));
        }

        foreach ($ids as $key => $value) {
            $batch->offsetUnset($key);
            $this->assertFalse($batch->offsetExists($key));
        }
    }

    public function testIteratorImplementation()
    {
        $batch = $this->getNewBatch();
        $ids = array(
            __LINE__,
            __LINE__,
            __LINE__
        );
        $batch->setIds($ids);

        foreach ($batch as $key => $value) {
            $this->assertTrue(isset($ids[$key]));
            $this->assertEquals($ids[$key], $value);
        }

        reset($ids);
        $batch->rewind();
        $this->assertEquals(key($ids), $batch->key());
        $this->assertEquals(current($ids), $batch->current());

        next($ids);
        $batch->next();
        $this->assertEquals(key($ids), $batch->key());
        $this->assertEquals(current($ids), $batch->current());
    }
} 