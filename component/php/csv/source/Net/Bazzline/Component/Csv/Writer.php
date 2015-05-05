<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv;

use SplFileObject;

class Writer
{
    /** @var SplFileObject */
    private $handler;

    /** @var false|array */
    private $headlines = false;

    /** @var string */
    private $path;

    //begin of general
    /**
     * @return bool
     */
    public function hasHeadline()
    {
        return ($this->headlines !== false);
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
     * @param mixed|array $data
     * @return int
     */
    public function writeOne($data)
    {
        return $this->handler->fputcsv($data);
    }

    public function writeMany(array $collection)
    {
        foreach ($collection as $data) {
            $this->writeOne($data);
        }
    }

    public function writeHeadlines(array $headlines)
    {
        $this->headlines = $headlines;
        $this->writeOne($headlines);
    }
    //end of general

    /**
     * @param string $path
     * @return SplFileObject
     * @todo inject or inject factory
     */
    private function open($path)
    {
        $file = new SplFileObject($path, 'w');
        $file->setFlags(SplFileObject::READ_CSV);

        return $file;
    }
}