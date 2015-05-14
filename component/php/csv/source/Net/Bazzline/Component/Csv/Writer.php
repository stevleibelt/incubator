<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv;

class Writer extends AbstractBase
{
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
     * @param array|mixed $data
     * @return false|int
     */
    public function writeOne($data)
    {
        return $this->getFileHandler()->fputcsv($data, $this->getDelimiter(), $this->getEnclosure());
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
        $this->setHeadline($headlines);
        $this->writeOne($headlines);
    }
    //end of general

    /**
     * @return string
     */
    protected function getFileHandlerOpenMode()
    {
        return 'w';
    }
}