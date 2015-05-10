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

    public function testHasHeadline()
    {
$this->markTestSkipped();
        $content    = $this->contentAsArray;
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $expectedContent    = array_slice($content, 1);
        $expectedHeadline   = $content[0];

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());
        $reader->enableHasHeadline();

        $this->assertTrue($reader->hasHeadline(), 'has headline');
        $this->assertEquals($expectedContent, $reader->readAll(), 'read all');
        $this->assertEquals($expectedHeadline, $reader->readHeadline(), 'read headline');
    }

    public function testReadWholeContentAtOnce()
    {
$this->markTestSkipped();
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $this->assertFalse($reader->hasHeadline());
        $this->assertEquals($this->contentAsArray, $reader->readAll());
    }

    public function testReadWholeContentByUsingTheIteratorInterface()
    {
$this->markTestSkipped();
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

    public function testReadWholeContentByUsingReaderAsAFunction()
    {
$this->markTestSkipped();
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;

        while ($line = $reader()) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    public function testReadWholeContentLinePerLine()
    {
$this->markTestSkipped();
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;

        while ($line = $reader->readOne()) {
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
            /*
            'read only the first line' => array(
                'content'   => $content,
                'end'       => $indices[1],
                'start'     => $indices[0]
            ),
            */
            'read one line the middle' => array(
                'content'   => $content,
                'end'       => $indices[2],
                'start'     => $indices[1]
            ),
            'read whole content' => array(
                'content'   => $content,
                'end'       => $indices[($length - 1)],
                'start'     => $indices[0]
            )
        );
    }

    /**
     * @dataProvider readChunkOfTheContentDataProvider
     * @param string $fullFileContent
     * @param int $end
     * @param int $start
     */
    public function testReadChunkOfTheContentByProvidingStartLineNumberAndAmountOfLines($fullFileContent, $end, $start)
    {
        $file           = $this->createFile();
        $filesystem     = $this->createFilesystem();
        $length  = ($end - $start);
        $reader         = $this->createReader();

        $file->setContent($this->convertArrayToStrings($fullFileContent));
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $expectedContent = array();

        $counter = $start;

        while ($counter < $end) {
            $expectedContent[] = $fullFileContent[$counter];
            ++$counter;
        }
echo '>>>>' . PHP_EOL;
echo 'start: ' . var_export($start, true) . PHP_EOL;
echo 'end: ' . var_export($end, true) . PHP_EOL;
echo 'length: ' . var_export($length, true) . PHP_EOL;
echo 'expected: ' . var_export($expectedContent, true) . PHP_EOL;
echo 'got: ' . var_export($reader->readMany($length, $start), true) . PHP_EOL;
echo '<<<<' . PHP_EOL;

        //$this->assertEquals($expectedContent, $reader->readMany($length, $start));
        $this->fail('----');
    }

    public function testReadContentByProvidingTheCurrentLineNumber()
    {
$this->markTestSkipped();
        $data       = $this->contentAsArray;
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        foreach ($data as $lineNumber => $line) {
            $this->assertEquals($line, $reader->readOne($lineNumber));
        }
    }

    public function testReadContentByProvidingTheCurrentLineNumberByUsingReaderAsAFunction()
    {
$this->markTestSkipped();
        $data       = $this->contentAsArray;
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        foreach ($data as $lineNumber => $line) {
            $this->assertEquals($line, $reader($lineNumber));
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
            $string .= implode($delimiter, $contents) . PHP_EOL;
        }

        return $string;
    }
}
