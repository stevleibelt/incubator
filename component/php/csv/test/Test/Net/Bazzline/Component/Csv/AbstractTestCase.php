<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

use Net\Bazzline\Component\Csv\Reader;
use Net\Bazzline\Component\Csv\Writer;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
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
     * @param string $name
     * @param int $permissions
     * @return \org\bovigo\vfs\vfsStreamFile
     */
    protected function createFile($name = 'test.csv', $permissions = 0700)
    {
        return vfsStream::newFile($name, $permissions);
    }

    /**
     * @return Reader
     */
    protected function createReader()
    {
        return new Reader();
    }

    /**
     * @return Writer
     */
    protected function createWriter()
    {
        return new Writer();
    }
}