<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-02 
 */

namespace Net\Bazzline\Component\Cli\Autocomplete;

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
     * @todo implement validation
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
        $prompt = $this->prompt;

        while (true) {
            $line   = readline($prompt);
            $tokens = explode(' ', $line);

            readline_add_history($line);
            usleep(500000);
        }
    }

    /**
     * @param string $input
     * @param int $index
     * @param int $length
     * @return false|array
     */
    private function autocomplete($input, $index, $length)
    {
        return false;
    }

    private function registerAutocomplete()
    {
        readline_completion_function(array($this, 'autocomplete'));
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