<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-05-13
 */

namespace Net\Bazzline\Component\Csv;

class WriterForPhp5Dot3 extends Writer
{
    /**
     * @param mixed|array $data
     * @return false|int
     */
    public function writeOne($data)
    {
        return fputcsv($this->getFileHandler(), $data, $this->getDelimiter(), $this->getEnclosure(), $this->getEscapeCharacter());
    }

    /**
     * @param string $path
     * @return resource
     */
    protected function open($path)
    {
        $file = fopen($path, $this->getFileHandlerOpenMode());

        return $file;
    }
}