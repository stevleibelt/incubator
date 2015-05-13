<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv;

class WriterFactory extends AbstractFactory
{
    /**
     * @return object
     */
    public function create()
    {
        if (version_compare(phpversion(), '5.4', '<')) {
            $writer = new WriterForPhp5Dot3();
        } else {
            $writer = new Writer();
        }

        $writer->setDelimiter($this->getDelimiter());
        $writer->setEnclosure($this->getEnclosure());
        $writer->setEscapeCharacter($this->getEscapeCharacter());

        return $writer;
    }
}