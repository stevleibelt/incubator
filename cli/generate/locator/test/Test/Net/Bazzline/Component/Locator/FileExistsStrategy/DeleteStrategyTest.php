<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-09 
 */

namespace Test\Net\Bazzline\Component\Locator\FileExistsStrategy;

use org\bovigo\vfs\vfsStream;
use Test\Net\Bazzline\Component\Locator\LocatorTestCase;

/**
 * Class DeleteStrategyTest
 * @package Test\Net\Bazzline\Component\Locator\FileExistsStrategy
 */
class DeleteStrategyTest extends LocatorTestCase
{
    public function testExecuteWithNotDeletableFile()
    {
        $this->markTestSkipped('vfsStream seams to have a bug inside. We can unlink this file, even without having read or write permissions.');
        $strategy = $this->getDeleteStrategy();
        $root = vfsStream::setup('root', 0700);
        $file = vfsStream::newFile('file', 0000);
        $root->addChild($file);

        $strategy->setFilePath($root->url());
        $strategy->setFileName('file');

        $strategy->execute();
    }

    public function testExecuteWithDeletableFile()
    {
        $strategy = $this->getDeleteStrategy();
        $root = vfsStream::setup('root', 0700);
        $file = vfsStream::newFile('file', 0700);
        $root->addChild($file);

        $strategy->setFilePath($root->url());
        $strategy->setFileName('file');

        $strategy->execute();
    }
}