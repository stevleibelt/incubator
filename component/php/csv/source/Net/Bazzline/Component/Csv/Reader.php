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
echo 'line number: ' . $lineNumber . PHP_EOL;
echo 'key: ' . $this->key() . PHP_EOL;
        $this->seekFileToCurrentLineNumberIfNeeded($file, $lineNumber);
echo 'key: ' . $this->key() . PHP_EOL;

        $content = $this->current();
echo 'key: ' . $this->key() . PHP_EOL;
        $this->next();
echo 'key: ' . $this->key() . PHP_EOL;

        return $content;
    }

    /**
     * @param int $length
     * @param null|int $lineNumberToStartWith - if "null", current line number is used
     * @return array
     */
    public function readMany($length, $lineNumberToStartWith = null)
    {
        $lastLine       = $lineNumberToStartWith + $length;
        $lines          = array();
        $currentLine    = $lineNumberToStartWith;

        //foreach not usable here since it is calling rewind before iterating
echo '====' . PHP_EOL;
echo '>>while loop start' . PHP_EOL;
        while ($currentLine < $lastLine) {
            $lines[] = $this->readOne($currentLine);
            if (!$this->valid()) {
                $currentLine = $lastLine;
echo 'became invalid for current line: ' . $currentLine . PHP_EOL;
            }
            ++$currentLine;
        }
echo '>>while loop end' . PHP_EOL;
echo '____________' . PHP_EOL;
echo 'final currentLine: ' . $currentLine . PHP_EOL;
echo 'length: ' . $length . PHP_EOL;
echo 'lines: ' . var_export($lines, true). PHP_EOL;
echo '====' . PHP_EOL;

        return $lines;
    }

    /**
     * @return array
     */
    public function readAll()
    {
        $lines  = array();

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