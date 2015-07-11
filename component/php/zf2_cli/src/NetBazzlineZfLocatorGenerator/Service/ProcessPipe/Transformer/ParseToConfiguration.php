<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class ParseToConfiguration implements ExecutableInterface
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

        $output = array();

        foreach ($input as $line) {
            //remove description
            $breadcrumb                     = array();
            $positionOfMultipleWhitespaces  = strpos($line, '  ');

            if (is_numeric($positionOfMultipleWhitespaces)) {
                $line = substr($line, 0, $positionOfMultipleWhitespaces);
            }

            //replace multiple whitespaces with one
            //$line = preg_replace('/\s+/', ' ',$line);
            $tokens = explode(' ', $line);

            foreach ($tokens as $token) {
                $isValid = true;
                //we don't care of "--foo", "-f", <foo>, [<foo>] nor [foo]
                //  @see:
                //      http://framework.zend.com/manual/current/en/modules/zend.console.routes.html
                //      http://framework.zend.com/manual/current/en/modules/zend.console.routes.html#console-routes-cheat-sheet
                foreach (array('-', '<', '[') as $needle) {
                    if ($this->startsWith($token, $needle)) {
                        $isValid = false;
                        break;
                    }
                }

                if ($isValid) {
                    $breadcrumb[] = $token;
                }
            }
            $output = $this->addToArray($output, $breadcrumb);
        }

        return $output;
    }

    /**
     * @param array $array
     * @param array $path
     * @return array
     * @todo replace with external dependency
     */
    private function addToArray(array $array, array $path)
    {
        $section = array_shift($path);

        if (!isset($array[$section])) {
            $array[$section]= array();
        }

        if (!empty($path)) {
            $array[$section] = addToArray($array[$section], $path);
        }

        return $array;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     * @todo replace with external dependency
     */
    private function startsWith($haystack, $needle)
    {
        return (strncmp($haystack, $needle, strlen($needle)) === 0);
    }

}