<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Net\Bazzline\Component\Cli\Readline;


use Net\Bazzline\Component\Cli\Readline\Configuration\Assembler;
use Net\Bazzline\Component\Cli\Readline\Configuration\Executable;
use Net\Bazzline\Component\Cli\Readline\Configuration\Validator;

class ManagerFactory
{
    /**
     * @return Manager
     */
    public function create()
    {
        $manager = new Manager();

        $manager->setAssembler($this->createAssembler());
        $manager->setAutocomplete($this->createAutocomplete());
        $manager->setReadLine($this->createReadLine());

        return $manager;
    }

    /**
     * @return Assembler
     */
    protected function createAssembler()
    {
        $assembler = new Assembler();

        $assembler->setExecutable(new Executable());
        $assembler->setValidator(new Validator());

        return $assembler;
    }

    /**
     * @return Autocomplete
     */
    protected function createAutocomplete()
    {
        return new Autocomplete();
    }

    /**
     * @return ReadLine
     */
    protected function createReadLine()
    {
        return new ReadLine();
    }
}