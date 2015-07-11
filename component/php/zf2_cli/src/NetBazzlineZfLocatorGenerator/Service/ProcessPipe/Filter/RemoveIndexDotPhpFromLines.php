<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class RemoveIndexDotPhpFromLines implements ExecutableInterface
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

        $output = array_map(function ($line) {
            $line = str_replace(array('public/index.php', 'index.php'), '', $line);
            $line = trim($line);

            return $line;
        }, $input);

        return $output;
    }
}