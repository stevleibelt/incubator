<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Filter;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @param string $string
     * @param string $start
     * @param string $end
     * @return null|string
     * @todo move into dedicated component/repository
     */
    protected function sliceSection($string, $start, $end)
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
    protected function startsWith($string, $start)
    {
        return (strncmp($string, $start, strlen($start)) === 0);
    }
}