<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv;

//@see https://github.com/ajgarlag/AjglCsv/blob/master/Reader/ReaderAbstract.php
//@see https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Reader.php
use Iterator;
use SplFileObject;

class Reader extends AbstractBase implements Iterator
{
    /** @var int */
    private $currentLineNumber = 0;

    /** @var false|array */
    private $headline = false;

    /**
     * @param null $currentLineNumber
     * @return array|bool|string
     */
    public function __invoke($currentLineNumber = null)
    {
        return $this->readOne($currentLineNumber);
    }

    //begin of Iterator
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->getFileHandler()->current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        ++$this->currentLineNumber;
        $this->getFileHandler()->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->getFileHandler()->key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->getFileHandler()->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        if ($this->hasHeadline()) {
            $this->currentLineNumber = 1;
            $this->getFileHandler()->seek(1);
        } else {
            $this->currentLineNumber = 0;
            $this->getFileHandler()->rewind();
        }
    }
    //end of Iterator

    //begin of headlines
    /**
     * @return $this
     */
    public function disableHasHeadline()
    {
        $this->headline = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function enableHasHeadline()
    {
        $currentLineNumber  = $this->getCurrentLineNumber();
        $file               = $this->getFileHandler();
        $this->headline     = $this->readOne(0);

        $this->seekFileToCurrentLineNumberIfNeeded($file, $currentLineNumber);

        return $this;
    }
    /**
     * @return bool
     */
    public function hasHeadline()
    {
        return ($this->headline !== false);
    }

    /**
     * @return false|array
     */
    public function readHeadline()
    {
        return $this->headline;
    }
    //end of headlines

    //begin of general

    /**
     * @param null|int $currentLineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($currentLineNumber = null)
    {
        $file = $this->getFileHandler();
        $file = $this->seekFileToCurrentLineNumberIfNeeded($file, $currentLineNumber);

        $content = $file->current();
        $this->next();

        return $content;
    }

    /**
     * @param int $numberOfLines
     * @param null|int $currentLineNumber - if "null", current line number is used
     * @return array
     */
    public function readMany($numberOfLines, $currentLineNumber = null)
    {
        $counter    = 0;
        $file       = $this->getFileHandler();
        $lines      = array();

        $file = $this->seekFileToCurrentLineNumberIfNeeded($file, $currentLineNumber);

        while ($counter <= $numberOfLines) {
            $lines[] = $file->current();
            if ($file->eof()) {
                break;
            } else {
                $this->next();
                ++$counter;
            }
        }

        return $lines;
    }

    /**
     * @return array
     */
    public function readAll()
    {
        $file   = $this->getFileHandler();
        $lines  = array();

        $this->rewind();

        while (true) {
            //$lines[] = $file->fgetcsv();
            $lines[] = $file->current();
            $file->next();
            if ($file->eof()) {
                break;
            }
        }

        return $lines;
    }

    /**
     * @return int
     */
    public function getCurrentLineNumber()
    {
        return $this->currentLineNumber;
    }
    //end of general
    /**
     * @return string
     */
    protected function getFileHandlerOpenMode()
    {
        return 'r';
    }

    /**
     * @param SplFileObject $file
     * @param null|int $currentLineNumber
     * @return SplFileObject
     */
    private function seekFileToCurrentLineNumberIfNeeded(SplFileObject $file, $currentLineNumber = null)
    {
        $seekIsNeeded = ((!is_null($currentLineNumber))
            && ($currentLineNumber !== $this->currentLineNumber));

        if ($seekIsNeeded) {
            $file->seek($currentLineNumber);
            $this->currentLineNumber = $currentLineNumber;
        }

        return $file;
    }
}