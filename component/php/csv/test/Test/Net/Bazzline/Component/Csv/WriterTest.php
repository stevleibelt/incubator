<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-03
 */

namespace Test\Net\Bazzline\Component\Csv;

//@todo implement call of this tests with different delimiters etc. (after the 
//setters are developed
class WriterTest extends AbstractTestCase
{
    /**
     * @var array
     */
    private $contentAsArray = array(
        array(
            'headlines foo',
            'headlines bar'
        ),
        array(
            'foo',
            'bar'
        ),
        array(
            'foobar',
            'baz'
        ),
        array(
            'baz',
            'barfoo'
        )
    );

    public function testWriteContentLinePerLineUsingWriteOne()
    {
        $collection         = $this->contentAsArray;
        $expectedContent    = $this->convertArrayToStrings($collection);
        $file               = $this->createFile();
        $filesystem         = $this->createFilesystem();
        $writer             = $this->createWriter();

        $filesystem->addChild($file);
        $writer->setPath($file->url());

        foreach ($collection as $content) {
            $this->assertNotFalse($writer->writeOne($content));
        }

        $this->assertEquals($expectedContent, $file->getContent());
    }

    /*
    public function testReadWholeContentAtOnce()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $this->assertFalse($reader->hasHeadline());
        $this->assertEquals($this->contentAsArray, $reader->readAllLines());
    }

    public function testReadWholeContentByUsingTheIteratorInterface()
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

    public function testReadWholeContentLinePerLine()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;

        while ($line = $reader->readOneLine()) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    public function readChunkOfTheContentDataProvider()
    {
        $content        = $this->contentAsArray;
        $indices        = array_keys($content);
        $length         = count($indices);

        return array(
            'read something from the middle' => array(
                'content'   => $content,
                'end'       => $indices[($length - 2)],
                'start'     => $indices[(1)]
            )
        );
    }

    public function testReadChunkOfTheContentByProvidingStartLineNumberAndAmountOfLines($fullFileContent, $end, $start)
    {
        $file           = $this->createFile();
        $filesystem     = $this->createFilesystem();
        $numberOfLines  = ($end - $start);
        $reader         = $this->createReader();

        $file->setContent($this->convertArrayToStrings($fullFileContent));
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $expectedContent = array();

        $counter = $start;

        while ($counter <= $end) {
            $expectedContent[] = $fullFileContent[$counter];
            ++$counter;
        }

        $this->assertEquals($expectedContent, $reader->readManyLines($numberOfLines, $start));
    }

    public function testReadContentByProvidingTheCurrentLineNumber()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $lineNumber = (count($this->contentAsArray) - 1);

        while ($lineNumber > 0) {
            $this->assertEquals($this->contentAsArray[$lineNumber], $reader->readOneLine($lineNumber));
            --$lineNumber;
        }
    }
     */

    private function getContentAsString()
    {
        return $this->convertArrayToStrings($this->contentAsArray);
    }

    private function convertArrayToStrings(array $data, $delimiter = ',')
    {
        $string = '';

        foreach ($data as $contents) {
            foreach ($contents as &$part) {
                $contains = $this->stringContains(' ');
                if ($contains->evaluate($part, '', true)) {
                    $part = '"' . $part . '"';
                }
            }
            $string .= implode($delimiter, $contents) . PHP_EOL;
        }

        return $string;
    }
}
