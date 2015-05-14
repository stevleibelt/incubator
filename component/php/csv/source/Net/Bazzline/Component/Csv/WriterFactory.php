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
        $writer = $this->createNewWriter();

        $writer->setDelimiter($this->getDelimiter());
        $writer->setEnclosure($this->getEnclosure());
        $writer->setEscapeCharacter($this->getEscapeCharacter());

        return $writer;
    }

    /**
     * @return Writer|WriterForPhp5Dot3
     */
    protected function createNewWriter()
    {
        if ($this->phpVersionLessThen5Dot4()) {
            $writer = new WriterForPhp5Dot3();
        } else {
            $writer = new Writer();
        }

        return $writer;
    }

    /**
     * @return boolean
     */
    protected function phpVersionLessThen5Dot4()
    {
        return (version_compare(phpversion(), '5.4', '<'));
    }
}