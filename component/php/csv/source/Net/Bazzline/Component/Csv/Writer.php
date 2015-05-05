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

    /**
     * @param mixed|array $data
     * @return false|int
     */
    public function __invoke($data)
    {
        return $this->writeOne($data);
    }


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
     * @return false|int
     */
    public function writeOne($data)
    {
        return $this->handler->fputcsv($data);
    }

    /**
     * @param array $collection
     * @return false|int
     */
    public function writeMany(array $collection)
    {
        $lengthOfTheWrittenStrings = 0;

        foreach ($collection as $data) {
            $lengthOfTheWrittenString = $this->writeOne($data);

            if ($lengthOfTheWrittenString === false) {
                $lengthOfTheWrittenStrings = $lengthOfTheWrittenString;
                break;
            } else {
                $lengthOfTheWrittenStrings += $lengthOfTheWrittenString;
            }
        }

        return $lengthOfTheWrittenStrings;
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