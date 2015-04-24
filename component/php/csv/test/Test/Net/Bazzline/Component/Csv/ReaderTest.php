<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

class ReaderTest extends AbstractTestCase
{
    /**
     * @var array
     */
    private $contentAsArray = array(
        array(
            'headline foo',
            'headline bar'
        ),
        array(
            'foo',
            'bar'
        ),
        array(
            'foobar',
            'baz'
        )
    );

    public function testReadingWholeContentByUsingGetLines()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $this->assertEquals($this->contentAsArray, $reader->getLines());
    }

    public function testReadingWholeContentWhileIterating()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;
        foreach ($reader as $line) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    public function testReadingWholeContentPerLineUsingGetLine()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;

        while ($line = $reader->getLine()) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    public function testReadingContentPerLineUsingGetLineAndLineNumber()
    {
        $this->markTestIncomplete();
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $lineNumber = (count($this->contentAsArray) - 1);

        while ($lineNumber > 0) {
            echo $lineNumber . PHP_EOL;
            $this->assertEquals($this->contentAsArray[$lineNumber], $reader->getLine(null, $lineNumber));
            --$lineNumber;
        }
    }

    /**
     * @return string
     */
    private function getContentAsString()
    {
        $string = '';

        foreach ($this->contentAsArray as $contents) {
            $string .= implode(',', $contents) . PHP_EOL;
        }

        return $string;
    }
}