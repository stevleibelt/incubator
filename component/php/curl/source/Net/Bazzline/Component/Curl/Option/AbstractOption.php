<?php

namespace Net\Bazzline\Component\Curl\Option;

abstract class AbstractOption
{
    /**
     * @return int
     */
    abstract public function identifier();

    /**
     * @return mixed
     */
    abstract public function value();
}