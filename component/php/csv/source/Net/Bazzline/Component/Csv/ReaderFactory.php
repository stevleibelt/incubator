<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv;

class ReaderFactory implements FactoryInterface
{
    /**
     * @return object|Reader
     */
    public function create()
    {
        $reader = new Reader();

        return $reader;
    }
}