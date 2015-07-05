<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-02 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete;

use InvalidArgumentException;
use Net\Bazzline\Component\Cli\Autocomplete\Configuration\Executable;
use RuntimeException;

class Manager
{
    /** @var array */
    private $configuration;

    /** @var string */
    private $prompt;

    /**
     * @param array $configuration
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param string $prompt
     * @return $this
     */
    public function setPrompt($prompt)
    {
        $this->prompt = (string) $prompt;

        return $this;
    }

    public function run()
    {
        $this->validateEnvironment();
        $this->registerAutocomplete();

        $configuration  = $this->configuration;
        $prompt         = $this->prompt;

        while (true) {
            $line   = trim(readline($prompt));
            $tokens = explode(' ', $line);

            if (!empty($tokens)) {
                $this->executeFromConfiguration($tokens, $configuration);
                echo PHP_EOL;
            }

            readline_add_history($line);
            usleep(500000);
        }
    }

    /**
     * @param string $input
     * @param int $index
     * @return false|array
     */
    private function autocomplete($input, $index)
    {
        $configuration = $this->configuration;

        if ($index == 0) {
            $completion = array_keys($configuration);
        } else {
            $buffer     = preg_replace('/\s+/', ' ', trim(readline_info('line_buffer')));
            $tokens     = explode(' ', $buffer);
            $completion = $this->fetchCompletionFromLevel($configuration, $tokens);
        }

        return $completion;
    }

    /**
     * @param array $configuration
     * @param array $tokens
     * @return array|bool
     */
    private function fetchCompletionFromLevel(array $configuration, array &$tokens)
    {
        $completion = false;
        $index      = current($tokens);

        if (isset($configuration[$index])) {
            if (next($tokens) !== false) {
                $completion = $this->fetchCompletionFromLevel($configuration[$index], $tokens);
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

    private function registerAutocomplete()
    {
        readline_completion_function(array($this, 'autocomplete'));
    }

    /**
     * @param array $tokens
     * @param $configuration
     */
    private function executeFromConfiguration(array $tokens, $configuration)
    {
        if ($configuration instanceof Executable) {
            $configuration->execute($tokens);
        } else {
            $token          = array_shift($tokens);
            $isValidToken   = (!is_null($token) && (strlen($token) > 0));

            if ($isValidToken) {
                if (isset($configuration[$token])) {
                    $this->executeFromConfiguration($tokens, $configuration[$token]);
                }
            }
        }
    }

    /**
     * @throws RuntimeException
     */
    private function validateEnvironment()
    {
        if (!function_exists('readline')) {
            throw new RuntimeException('readline not installed');
        }
    }
}