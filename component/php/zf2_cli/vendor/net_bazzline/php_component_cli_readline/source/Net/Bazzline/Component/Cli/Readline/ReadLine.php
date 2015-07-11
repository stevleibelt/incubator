<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Readline;

use Net\Bazzline\Component\Cli\Readline\Configuration\Executable;

class ReadLine
{
    /** @var array */
    private $configuration;

    /**
     * @param string $prompt
     */
    public function __invoke($prompt)
    {
        $this->readLine($prompt);
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $prompt
     */
    public function readLine($prompt)
    {
        $configuration  = $this->configuration;
        $line           = trim(readline($prompt));
        $tokens         = explode(' ', $line);

        if (!empty($tokens)) {
            $this->executeIfPossible($tokens, $configuration);
            readline_add_history($line);
        }
    }

    /**
     * @param array $tokens
     * @param $configuration
     */
    private function executeIfPossible(array $tokens, $configuration)
    {
        if ($configuration instanceof Executable) {
            $configuration->execute($tokens);
        } else {
            $token          = array_shift($tokens);
            $isValidToken   = (!is_null($token) && (strlen($token) > 0));

            if ($isValidToken) {
                if (isset($configuration[$token])) {
                    $this->executeIfPossible($tokens, $configuration[$token]);
                }
            }
        }
    }
}