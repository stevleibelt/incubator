<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\Fork\Example\WithReachingMemoryLimit;

use Net\Bazzline\Component\Fork\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\Fork\Example\WithReachingMemoryLimit
 */
class ExampleTask extends AbstractTask
{
    /**
     * @var int
     */
    private $numberOfDataMultiplication;

    /**
     * @return int
     */
    public function getNumberOfDataMultiplication()
    {
        return $this->numberOfDataMultiplication;
    }

    /**
     * @param int $number
     */
    public function setNumberOfDataMultiplication($number)
    {
        $this->numberOfDataMultiplication = $number;
    }

    /**
     * @throws \Net\Bazzline\Component\Fork\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $startTime = time();
        $workingDataSet = array();

        echo $identifier . ' says hello' . PHP_EOL;
        echo $identifier . ' number of data multiplication ' . $this->numberOfDataMultiplication . PHP_EOL;
        echo $identifier . ' memory usage ' . (memory_get_usage(true) / 1024 / 1024) . ' MB ' .PHP_EOL;
        echo PHP_EOL;

        for ($iterator = 0; $iterator < $this->numberOfDataMultiplication; ++$iterator) {
            //begin creating one megabyte of data
            //taken from https://github.com/stevleibelt/examples/blob/master/php/array/createOneMegaByteOfData.php
            $anotherRound = true;
            $data = array();
            $initialMemoryUsage = memory_get_usage(true);
            $anotherIterator = 0;
            $memoryUsageInMegaByteToGenerate = 1;

            while ($anotherRound) {
                $data[] = $anotherIterator;
                $currentMemoryUsage = (memory_get_usage(true) - $initialMemoryUsage);
                $currentMemoryUsageInMegaBytes = ($currentMemoryUsage / (1024 * 1024));
                if ($currentMemoryUsageInMegaBytes === $memoryUsageInMegaByteToGenerate) {
                    $anotherRound = false;
                }
                ++$anotherIterator;
            }
            //end creating one megabyte of data
            $workingDataSet[] = $data;
        }

        echo $identifier . ' says goodbye' . PHP_EOL;
        echo $identifier . ' runtime: ' . (time() - $startTime) . ' seconds' . PHP_EOL;
        echo $identifier . ' memory usage ' . (memory_get_usage(true) / 1024 / 1024) . ' MB ' .PHP_EOL;
        echo PHP_EOL;
    }
}