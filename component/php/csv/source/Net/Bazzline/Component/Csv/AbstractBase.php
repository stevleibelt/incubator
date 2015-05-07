<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv;

use SplFileObject;

abstract class AbstractBase
{
    /** @var string */
    private $delimiter = ',';

    /** @var string */
    private $enclosure = '"';

    /** @var string */
    private $escapeCharacter = '\\';

    /** @var SplFileObject */
    private $handler;

    /** @var string */
    private $path;

    /**
     * @param string $delimiter
     * @throws InvalidArgumentException
     */
    public function setDelimiter($delimiter)
    {
        $this->assertIsASingleCharacterString($delimiter, 'delimiter');
        $this->delimiter = $delimiter;
    }

    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     */
    public function setEnclosure($enclosure)
    {
        $this->assertIsASingleCharacterString($enclosure, 'enclosure');
        $this->enclosure = $enclosure;
    }

    /**
     * @param string $escapeCharacter
     */
    public function setEscapeCharacter($escapeCharacter)
    {
        $this->assertIsASingleCharacterString($escapeCharacter, 'escapeCharacter');
        $this->escapeCharacter = $escapeCharacter;
    }

    /**
     * @param string $path
     * @return $this
     * @throws InvalidArgumentException
     * @todo implement validation
     */
    public function setPath($path)
    {
        $this->path     = $path;
        $this->handler  = $this->open($path);

        return $this;
    }

    /**
     * @return string
     */
    protected function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @return string
     */
    protected function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @return string
     */
    protected function getEscapeCharacter()
    {
        return $this->escapeCharacter;
    }

    /**
     * @return SplFileObject
     */
    protected function getFileHandler()
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    abstract protected function getFileHandlerOpenMode();

    /**
     * @param string $path
     * @return SplFileObject
     * @todo inject or inject factory
     */
    private function open($path)
    {
        $file = new SplFileObject($path, $this->getFileHandlerOpenMode());
        $file->setFlags(SplFileObject::READ_CSV);

        return $file;
    }

    /**
     * @param string $variable
     * @param string $name
     * @throws InvalidArgumentException
     */
    private function assertIsASingleCharacterString($variable, $name)
    {
        if (!is_string($variable)) {
            $message = $name . ' must be of type "string"';

            throw new InvalidArgumentException($message);
        }
        if (strlen($variable) != 1) {
            $message = $name . ' must be a single character';

            throw new InvalidArgumentException($message);
        }
    }
}