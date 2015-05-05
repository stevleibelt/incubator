<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv;

class Writer
{
    /** @var false|array */
    private $headline = false;

    public function writeOne($data)
    {

    }

    public function writeMany(array $collection)
    {
        foreach ($collection as $data) {
            $this->writeOne($data);
        }
    }

    public function writeHeadlines(array $headlines)
    {
        $this->writeOne($headlines);
    }
}