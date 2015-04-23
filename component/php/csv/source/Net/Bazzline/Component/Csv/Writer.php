<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv;

class Writer extends AbstractCsv
{
    public function addLine(array $line)
    {

    }

    public function addLines(array $lines)
    {
        foreach ($lines as $line) {
            $this->addLine($line);
        }
    }

    public function copy($path, $filter = null)
    {

    }

    public function setHeadlines(array $headlines)
    {
        $this->truncate();
        $this->addLine($headlines);
    }

    public function truncate()
    {

    }
}