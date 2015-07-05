<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete;

class Autocomplete
{
    /** array */
    private $configuration;

    /**
     * @param string $input
     * @param int $index
     * @return array|bool
     */
    public function __invoke($input, $index)
    {
        return $this->complete($input, $index);
    }

    /**
     * @param string $input
     * @param int $index
     * @return array|bool
     */
    public function complete($input, $index)
    {
        $configuration = $this->configuration;

        if ($index == 0) {
            $completion = array_keys($configuration);
        } else {
            $buffer     = preg_replace('/\s+/', ' ', trim(readline_info('line_buffer')));
            $tokens     = explode(' ', $buffer);
            $completion = $this->fetchCompletion($configuration, $tokens);
        }

        return $completion;
    }

    /**
     * @param array $configuration
     * @return $this
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param array $configuration
     * @param array $tokens
     * @return array|bool
     */
    private function fetchCompletion(array $configuration, array &$tokens)
    {
        $completion = false;
        $index      = current($tokens);

        if (isset($configuration[$index])) {
            if (next($tokens) !== false) {
                $completion = $this->fetchCompletion($configuration[$index], $tokens);
            } else {
                $arrayOrExecutable = $configuration[$index];

                if (is_array($arrayOrExecutable)) {
                    $objectOrToken  = current($arrayOrExecutable);
                    $completion     = (is_object($objectOrToken)) ? false : array_keys($configuration[$index]);
                } else {
                    $completion = false;
                }
            }
        } else {
            $indexLengthIsGreaterZero   = (strlen($index) > 0);

            if ($indexLengthIsGreaterZero) {
                $position   = strlen($index);
                $values     = array_keys($configuration);
                $completion = array();

                foreach ($values as $value) {
                    if (substr($value, 0, $position) === $index) {
                        $completion[] = $value;
                    }
                }

                if (empty($completion)) {
                    $completion = false;
                }
            }
        }

        return $completion;
    }
}