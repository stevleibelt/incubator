<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Tool;

class StringTool
{
    /**
     * @param string $string
     * @param string $search
     * @return boolean
     */
    public function contains($string, $search)
    {
        if (strlen($search) == 0) {
            $contains = false;
        } else {
            $contains = !(strpos($string, $search) === false);
        }

        return $contains;
    }

    /**
     * @param string $string
     * @param string $start
     * @param string $end
     * @return null|string
     */
    public function crop($string, $start, $end)
    {
        $positionOfTheStart         = strpos($string, $start);
        $positionOfTheStartIsValid  = ($positionOfTheStart !== false);
        $section                    = null;

        if ($positionOfTheStartIsValid) {
            $positionOfTheStartWithLengthOfStart    = $positionOfTheStart + strlen($start);
            $lengthOfTheSection                     = strpos($string, $end, $positionOfTheStartWithLengthOfStart) - $positionOfTheStartWithLengthOfStart;   //start searching for $end at $positionOfTheStartWithLengthOfStart and subtract the length of the string including the end of $start

            $section = substr($string, $positionOfTheStartWithLengthOfStart, $lengthOfTheSection);
        }

        return $section;
    }

    /**
     * @param string $string
     * @param string $start
     *
     * @return bool
     */
    public function startsWith($string, $start)
    {
         return (strncmp($string, $start, strlen($start)) === 0);
    }
}