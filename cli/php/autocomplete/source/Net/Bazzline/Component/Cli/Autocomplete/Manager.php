<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-02 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete;

use InvalidArgumentException;
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
        $this->validateConfiguration($configuration);
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
            $line   = readline($prompt);
            $tokens = explode(' ', $line);

            if (!empty($tokens)) {
                $this->executeFromConfiguration($tokens, $configuration);
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
            $buffer = preg_replace('/\s+/', ' ', trim(readline_info('line_buffer')));
            $tokens = explode(' ', $buffer);

            $completion     = $this->fetchCompletionFromLevel($configuration, $tokens);
        }

        return $completion;
    }

    private function fetchCompletionFromLevel(array $configuration, array &$tokens)
    {
        $completion = false;
        $index      = current($tokens);

        if (isset($configuration[$index])) {
            if (next($tokens) !== false) {
                $completion = $this->fetchCompletionFromLevel($configuration[$index], $tokens);
            } else {
                $arrayOrString = $configuration[$index];

                if (is_array($arrayOrString)) {
                    $objectOrToken  = current($arrayOrString);
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

    private function executeFromConfiguration(array $tokens, array $configuration)
    {
        $token = array_shift($tokens);

        if (is_null($token)
            || (strlen($token) === 0)) {
            $this->execute($configuration, $tokens);
        } else {
            if (isset($configuration[$token])) {
                if (!empty($tokens)) {
                    $this->executeFromConfiguration($tokens, $configuration[$token]);
                } else {
                    $this->execute($configuration[$token]);
                }
            } else {
                array_unshift($tokens, $token);
                $this->execute($configuration, $tokens);
            }
        }
    }

    /**
     * @param $objectWithMethodOrFunctionName
     * @param array $arguments
     */
    private function execute($objectWithMethodOrFunctionName, $arguments = null)
    {
        if (is_array($objectWithMethodOrFunctionName)) {
            if (isset($objectWithMethodOrFunctionName[0])) {
                $object = $objectWithMethodOrFunctionName[0];
                $method = $objectWithMethodOrFunctionName[1];

                if (is_null($arguments)) {
                    $object->$method();
                } else {
                    $object->$method($arguments);
                }
            }
        } else {
            if (is_null($arguments)) {
                $objectWithMethodOrFunctionName();
            } else {
                $objectWithMethodOrFunctionName($arguments);
            }
        }
    }

    /**
     * @param array $configuration
     * @param string $path
     * @throws InvalidArgumentException
     * @todo exclude to class
     */
    private function validateConfiguration(array $configuration, $path = null)
    {
        if (empty($configuration)) {
            throw new InvalidArgumentException('configuration ' . (is_null($path) ? '' : ' in path "' . $path . '" ') . 'can not be empty');
        }

        foreach ($configuration as $index => $arrayOrCallable) {
            $path = (is_null($path)) ? $index : $path . '/' . $index;

            if (is_string($arrayOrCallable)) {
                if(!is_callable($arrayOrCallable)) {
                    throw new InvalidArgumentException('method in path "' . $path . '" must be callable');
                }
            } else if (is_array($arrayOrCallable)) {
                $object = current($arrayOrCallable);

                if (is_object($object)) {
                    $methodName = $arrayOrCallable[1];
                    if (!method_exists($object, $methodName)) {
                        throw new InvalidArgumentException(
                            'provided instance of "' . get_class($object) . '" in path "' . $path . '" does not have the method "' . $methodName . '"'
                        );
                    }
                } else {
                    $this->validateConfiguration($arrayOrCallable, $path);
                }
            } else {
                throw new InvalidArgumentException(
                    'can not handle value "' . var_export($arrayOrCallable, true) . '" in path "' . $path . '"'
                );
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