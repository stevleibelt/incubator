<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class RemoveColorsAndModuleHeadlines implements ExecutableInterface
{
    /**
     * @param mixed $input
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($input = null)
    {
        if (!is_array($input)) {
            throw new ExecutableException(
                'input must be an array'
            );
        }

        if (empty($input)) {
            throw new ExecutableException(
                'empty input provided'
            );
        }

        $moduleHeadlineDetected = false;
        $output                 = array();

        foreach ($input as $line) {
            //remove color codes
            $line       = preg_replace('/\033\[[0-9;]*m/', '', $line);
            $isValid    = true;

            //detect and filter module headlines
            if (startsWith($line, '-')) {
                $isValid = false;
                $moduleHeadlineDetected = ($moduleHeadlineDetected === true)
                    ? false
                    : true;
            } else if (strlen(trim($line)) === 0) {
                $isValid = false;
            }

            if ($moduleHeadlineDetected === true) {
                $isValid = false;
            }

            if ($isValid) {
                $output[] = $line;
            }
        }

        return $output;
    }
}