<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-02 
 */

namespace Net\Bazzline\Component\Cli\Readline;

use Net\Bazzline\Component\Cli\Readline\Configuration\Assembler;
use RuntimeException;

class Manager
{
    /** @var Assembler */
    private $assembler;

    /** @var Autocomplete */
    private $autocomplete;

    /** @var array */
    private $configuration;

    /** @var string */
    private $prompt;

    /** @var ReadLine */
    private $readLine;

    /**
     * @param Assembler $assembler
     */
    public function setAssembler(Assembler $assembler)
    {
        $this->assembler = $assembler;
    }

    /**
     * @param Autocomplete $autocomplete
     * @return $this
     */
    public function setAutocomplete(Autocomplete $autocomplete)
    {
        $this->autocomplete = $autocomplete;

        return $this;
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
     * @param string $prompt
     * @return $this
     */
    public function setPrompt($prompt)
    {
        $this->prompt = (string) $prompt;

        return $this;
    }

    /**
     * @param ReadLine $readLine
     * @return $this
     */
    public function setReadLine(ReadLine $readLine)
    {
        $this->readLine = $readLine;

        return $this;
    }

    public function run()
    {
        $this->validateEnvironment();

        $assembler      = $this->assembler;
        $autocomplete   = $this->autocomplete;
        $prompt         = $this->prompt;
        $readLine       = $this->readLine;

        $configuration  = $assembler->assemble($this->configuration);

        $autocomplete->setConfiguration($configuration);
        $readLine->setConfiguration($configuration);

        $this->registerAutocomplete($autocomplete);

        while (true) {
            $readLine($prompt);
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
     * @throws RuntimeException
     */
    private function validateEnvironment()
    {
        if (!function_exists('readline')) {
            throw new RuntimeException('readline not installed');
        }
    }
}