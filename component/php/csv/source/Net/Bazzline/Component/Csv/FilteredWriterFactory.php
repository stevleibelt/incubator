<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv;

class FilteredWriterFactory extends WriterFactory
{
    /**
     * @return FilteredWriter|FilteredWriterForPhp3Dot3
     */
    protected function createNewWriter()
    {
        if ($this->phpVersionLessThen5Dot4()) {
            $writer = new FilteredWriterForPhp3Dot3();
        } else {
            $writer = new FilteredWriter();
        }

        return $writer;
    }
}