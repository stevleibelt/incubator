<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-13 
 */

namespace Net\Bazzline\Component\BatchJob;

/**
 * Interface ChunkableInterface
 * @package Net\Bazzline\Component\BatchJob
 */
interface ChunkableInterface
{
    /**
     * @return null|int
     */
    public function getChunkId();

    /**
     * @param int $id
     * @return $this
     */
    public function setChunkId($id);

    /**
     * @return null|int
     */
    public function getChunkSize();

    /**
     * @param int $size
     * @return $this
     */
    public function setChunkSize($size);

    /**
     * @return bool
     */
    public function acquireChunk();

    /**
     * @return bool
     */
    public function releaseChunk();
}