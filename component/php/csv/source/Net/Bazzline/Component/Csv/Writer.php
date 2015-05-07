<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv;

class Writer extends AbstractBase
{
    /** @var false|array */
    private $headlines = false;

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
     * @param mixed|array $data
     * @return false|int
     */
    public function writeOne($data)
    {
        return $this->getFileHandler()->fputcsv($data, $this->getDelimiter(), $this->getEnclosure(), $this->getEscapeCharacter());
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
     * @return string
     */
    protected function getFileHandlerOpenMode()
    {
        return 'w';
    }
}