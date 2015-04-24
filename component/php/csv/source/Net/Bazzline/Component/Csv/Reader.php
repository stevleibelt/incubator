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

class Reader implements Iterator
{
    /** @var int */
    private $currentLineNumber = 0;

    /** @var SplFileObject */
    private $handler;

    /** @var string */
    private $path;

    //begin of Iterator
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->handler->current();
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
        $this->handler->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->handler->key();
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
        return $this->handler->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->currentLineNumber = 0;
        $this->handler->rewind();
    }
    //end of Iterator

    /**
     * @param string $path
     * @return $this
     * @throws InvalidArgumentException
     * @todo implement validation
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->handler = $this->open($path);

        return $this;
    }

    /**
     * @param null|callable $filter
     * @param null|int $lineNumber
     * @return array|bool|string
     */
    public function getLine($filter = null, $lineNumber = null)
    {
        $file = $this->handler;

        if (is_null($lineNumber)) {
            $lineNumber = $this->currentLineNumber;
        }

        if ($file->getCurrentLine() !== $lineNumber) {
            $file->seek($lineNumber);
        }

        if ($file->valid()) {
            $content = $file->current();
            $this->currentLineNumber = (++$lineNumber);
        } else {
            $content = false;
        }

        return $content;
    }

    /**
     * @param null|callable $filter
     * @param null|int $limit
     * @return array
     */
    public function getLines($filter = null, $limit = null)
    {
        $file   = $this->handler;
        $lines  = array();

        while (!$file->eof()) {
            $lines[] = $file->fgetcsv();
        }

        return $lines;
    }

    /**
     * @param string $path
     * @return SplFileObject
     * @todo inject or inject factory
     */
    private function open($path)
    {
        $file = new SplFileObject($path);
        $file->setFlags(SplFileObject::READ_CSV);

        return $file;
    }
}