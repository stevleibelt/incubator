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
    private $initialLineNumber = 0;

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
        return $this->getFileHandler()->fgetcsv($this->getDelimiter(), $this->getEnclosure(), $this->getEscapeCharacter());
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
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
            $lineNumber = 1;
        } else {
            $lineNumber = 0;
        }
        $this->initialLineNumber = $lineNumber;
        $this->seekFileToCurrentLineNumberIfNeeded(
            $this->getFileHandler(),
            $lineNumber
        );
    }
    //end of Iterator

    //begin of headlines
    /**
     * @return $this
     */
    public function disableHasHeadline()
    {
        $this->headline = false;
        $this->rewind();

        return $this;
    }

    /**
     * @return $this
     */
    public function enableHasHeadline()
    {
        $this->headline = $this->readOne(0);
        $this->rewind();

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
     * @param null|int $lineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($lineNumber = null)
    {
        $file = $this->getFileHandler();
        $this->seekFileToCurrentLineNumberIfNeeded($file, $lineNumber);

        $content = $this->current();
        $this->next();

        return $content;
    }

    /**
     * @param int $length
     * @param null|int $lineNumberToStartWith - if "null", current line number is used
     * @return array
     */
    public function readMany($length, $lineNumberToStartWith = null)
    {
        $counter    = 0;
        $file       = $this->getFileHandler();
        $lines      = array();

        $this->seekFileToCurrentLineNumberIfNeeded($file, $lineNumberToStartWith);

        //foreach not usable here since it is calling rewind before iterating
echo '====' . PHP_EOL;
        while (($this->valid()) && ($counter < $length)) {
echo __LINE__ . ' current key: ' . $this->key() . PHP_EOL;
            $lines[] = $this->current();
            //$lines[] = $file->current();
echo __LINE__ . ' current key: ' . $this->key() . PHP_EOL;
            $this->next();
//echo 'next key: ' . $this->key() . PHP_EOL;
            ++$counter;
        }
echo 'final counter: ' . $counter . PHP_EOL;
echo 'length: ' . $length . PHP_EOL;
echo '====' . PHP_EOL;

        /*
        foreach ($this as $line) {
//echo 'counter: ' . $counter . PHP_EOL;
            $lines[] = $line;
            ++$counter;
            if ($counter >= $length) {
                break;
            }
        }
        */

        return $lines;
    }

    /**
     * @return array
     */
    public function readAll()
    {
        $lines  = array();
        $this->rewind();

        foreach ($this as $line) {
            $lines[] = $line;
        }

        return $lines;
    }

    /**
     * @return int
     */
    public function getCurrentLineNumber()
    {
        return $this->key();
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
     * @param null|int $newLineNumber
     * @return SplFileObject
     */
    private function seekFileToCurrentLineNumberIfNeeded(SplFileObject $file, $newLineNumber = null)
    {
        $seekIsNeeded = ((!is_null($newLineNumber))
            && ($newLineNumber >= $this->initialLineNumber)
            && ($newLineNumber !== $this->key()));

        if ($seekIsNeeded) {
            $file->seek($newLineNumber);
        }

        return $file;
    }
}