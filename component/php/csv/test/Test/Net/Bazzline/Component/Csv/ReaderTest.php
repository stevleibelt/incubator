<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

//@todo implement call of this tests with different delimiters etc. (after the 
//setters are developed
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
        ),
        array(
            'baz',
            'barfoo'
        )
    );

    public function testReadWholeContentAtOnce()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

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



    /**
     * @dataProvider readChunkOfTheContentDataProvider
     * @param string $content
     * @param int $end
     * @param int $start
     */
    public function testReadChunkOfTheContentByProvidingStartLineNumberAndAmountOfLines($content, $end, $start)
    {
        $this->markTestIncomplete();
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->convertArrayToStrings($content));
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $numberOfLines  = ($end - $start);

        $content = $reader->readManyLines($numberOfLines, $start);
echo var_export(array($end, $start, $numberOfLines), true) . PHP_EOL;
echo var_export($content, true) . PHP_EOL;
    }

    public function testReadContentByProvidingTheCurrentLineNumber()
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
            $this->assertEquals($this->contentAsArray[$lineNumber], $reader->readOneLine($lineNumber));
            --$lineNumber;
        }
    }

    /**
     * @return string
     */
    private function getContentAsString()
    {
        return $this->convertArrayToStrings($this->contentAsArray);
    }



    /**
     * @param array $data
     * @param string $delimiter
     * @return string
     */
    private function convertArrayToStrings(array $data, $delimiter = ',')
    {
        $string = '';

        foreach ($data as $contents) {
            $string .= implode(',', $contents) . PHP_EOL;
        }

        return $string;
    }
}
