<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

use Net\Bazzline\Component\Csv\Reader;
use Net\Bazzline\Component\Csv\ReaderFactory;
use Net\Bazzline\Component\Csv\Writer;
use Net\Bazzline\Component\Csv\WriterFactory;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /** @var ReaderFactory */
    private $readerFactory;

    /** @var WriterFactory */
    private $writerFactory;

    final public function __construct()
    {
        $this->readerFactory = new ReaderFactory();
        $this->writerFactory = new WriterFactory();
    }

    /**
     * @param int $permissions
     * @param string $path
     * @return \org\bovigo\vfs\vfsStreamDirectory
     */
    protected function createFilesystem($permissions = 0700, $path = 'root')
    {
        return vfsStream::setup($path, $permissions);
    }

    /**
     * @param int $permissions
     * @param string $name
     * @return \org\bovigo\vfs\vfsStreamFile
     */
    protected function createFile($permissions = 0700, $name = 'test.csv')
    {
        return vfsStream::newFile($name, $permissions);
    }

    /**
     * @return Reader
     */
    protected function createReader()
    {
        return $this->readerFactory->create();
    }

    /**
     * @return Writer
     */
    protected function createWriter()
    {
        return $this->writerFactory->create();
    }
}