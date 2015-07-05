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
    /** @var Autocomplete */
    private $autocomplete;

    /** @var array */
    private $configuration;

    /** @var string */
    private $prompt;

    /**
     * @param Autocomplete $autocomplete
     * @return $this
     */
    public function setAutocomplete($autocomplete)
    {
        $this->autocomplete = $autocomplete;

        return $this;
    }

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

        $autocomplete   = $this->autocomplete;
        $configuration  = $this->configuration;
        $prompt         = $this->prompt;

        $autocomplete->setConfiguration($configuration);
        $this->registerAutocomplete($autocomplete);

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
     * @param Autocomplete $autocomplete
     */
    private function registerAutocomplete(Autocomplete $autocomplete)
    {
        readline_completion_function($autocomplete);
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