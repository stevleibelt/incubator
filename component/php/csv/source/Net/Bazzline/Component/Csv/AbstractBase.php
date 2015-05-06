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
        if (!is_string($delimiter)) {
            $message = 'delimiter must be of type "string"';

            throw new InvalidArgumentException($message);
        }
        if (strlen($delimiter) != 1) {
            $message = 'delimiter must be a single character';

            throw new InvalidArgumentException($message);
        }

        $this->delimiter = $delimiter;
    }

    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     */
    public function setEnclosure($enclosure)
    {
        if (!is_string($enclosure)) {
            $message = 'enclosure must be of type "string"';

            throw new InvalidArgumentException($message);
        }
        if (strlen($enclosure) != 1) {
            $message = 'enclosure must be a single character';

            throw new InvalidArgumentException($message);
        }

        $this->enclosure = $enclosure;
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
}