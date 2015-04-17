<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace De\Leibelt\Stev\Component\PHP\Csv;

use SplFileObject;

//@see: https://github.com/keboola/php-csv/blob/master/src/Keboola/Csv/CsvFile.php
//@see: https://github.com/swt83/php-csv/blob/master/src/Travis/CSV.php
//@see: https://github.com/stevleibelt/EasyCSV/tree/master/lib/EasyCSV
abstract class AbstractBase
{
    /** @var string */
    private $delimiter;

    /** @var string */
    private $enclosure;

    /** @var resource */
    private $handle;

    /** boolean */
    private $hasHeaders;

    /** @var int */
    private $currentLineNumber;

    /** @var string */
    private $path;

    /** @var string */
    private $mode;

    /**
     * @param null|string $path
     * @param string $delimiter
     * @param string $enclosure
     * @param bool $hasHeaders
     * @param string $mode
     * @see http://php.net/manual/en/function.fopen.php
     */
    public function __construct($path = null, $delimiter = ',', $enclosure = '"', $hasHeaders = true, $mode = 'a+')
    {
        $this->setDelimiter($delimiter);
        $this->setEnclosure($enclosure);
        if ($hasHeaders) {
            $this->enableHasHeaders();
        } else {
            $this->disableHasHeaders();
        }
        $this->setMode($mode);

        if (!is_null($path)) {
            $this->setPath($path);
        }
    }

    /**
     * @return $this
     */
    public function disableHasHeaders()
    {
        $this->hasHeaders = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function enableHasHeaders()
    {
        $this->hasHeaders = true;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasHeaders()
    {
        return $this->hasHeaders;
    }

    /**
     * @param string $delimiter
     * @return $this
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @param string $enclosure
     * @return $this
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->open($this->path);

        return $this;
    }

    /**
     * @param string $path
     * @throws RuntimeException
     * @see http://php.net/manual/en/splfileobject.construct.php
     */
    protected function open($path)
    {
        if (!file_exists($path)) {
            if (!touch($path)) {
                $message = 'could not create file in path "' . $path . '""';

                throw new RuntimeException($message);
            }
        }

        $this->handle = new SplFileObject($path);
        $this->handle->setFlags(SplFileObject::DROP_NEW_LINE);
        $this->handle->setFlags(SplFileObject::READ_AHEAD);
        $this->handle->setFlags(SplFileObject::SKIP_EMPTY);

        $this->currentLineNumber = 0;
    }
}