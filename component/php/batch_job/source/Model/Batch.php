<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\BatchJob\Model;


class Batch
{
    /** @var string */
    private $id;

    /** @var int */
    private $size;

    public function __construct(
        string $id,
        int $size
    ) {
        $this->id   = $id;
        $this->size = $size;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function size() : int
    {
        return $this->size;
    }
}