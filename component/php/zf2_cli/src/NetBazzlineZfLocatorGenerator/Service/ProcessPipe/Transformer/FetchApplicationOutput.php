<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer;


use Net\Bazzline\Component\Command\Command;
use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class FetchApplicationOutput implements ExecutableInterface
{
    /** @var Command */
    private $command;

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @param mixed $input
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($input = null)
    {
        if (!is_string($input)) {
            throw new ExecutableException(
                'input must be a string'
            );
        }

        if (!file_exists($input)) {
            throw new ExecutableException(
                'file "' . $input . '" does not exist'
            );
        }

        $command = $this->command;
        //no command validation because of the fact that the zf2 application
        //  is setting an exit code greater 0 since noting was executed
        $output =  $command->execute('/usr/bin/env php ' . $input, false);

        return $output;
    }
}