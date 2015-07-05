<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-03
 */

namespace Net\Bazzline\Component\Cli\Autocomplete;

//use reflection instead of extends, add logging before each method call
class DebugManager extends Manager
{
    /** @var string */
    private $pathToLogFile;

    /**
     * @param string $path
     * @return $this
     */
    public function setPathToLogFile($path)
    {
        $this->pathToLogFile = $path;
        file_put_contents($this->pathToLogFile, '');    //truncating log

        return $this;
    }

    /**
     * @param mixed $message
     * @return int
     */
    private function log($message)
    {
        $message = (is_scalar($message)) ? $message : var_export($message, true);

        return file_put_contents($this->pathToLogFile, $message . PHP_EOL, FILE_APPEND);
    }
}