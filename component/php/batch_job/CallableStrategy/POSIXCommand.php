<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-14 
 */

namespace Net\Bazzline\Component\BatchJob\CallableStrategy;

use Net\Bazzline\Component\BatchJob\CallableStrategyInterface;
use Net\Bazzline\Component\BatchJob\RuntimeException;

/**
 * Class POSIXCommand
 * @package Net\Bazzline\Component\BatchJob\CallableStrategy
 */
class POSIXCommand implements CallableStrategyInterface
{
    /**
     * @var string
     */
    private $pathToBatchJobStartFile;

    /**
     * @param $pathToBatchJobStartFile
     * @throws \Net\Bazzline\Component\BatchJob\RuntimeException
     */
    public function setPathToBatchJobStartFile($pathToBatchJobStartFile)
    {
        if (!file_exists($pathToBatchJobStartFile)) {
            throw new RuntimeException(
                'provided file "' . $pathToBatchJobStartFile . '" does not exists'
            );
        }

        if (!is_readable($pathToBatchJobStartFile)) {
            throw new RuntimeException(
                'provided file "' . $pathToBatchJobStartFile . '" is not readable'
            );
        }

        $this->pathToBatchJobStartFile = $pathToBatchJobStartFile;
    }

    /**
     * @param string $factoryName
     * @param int $chunkSize
     * @param int|string $chunkId
     * @throws RuntimeException
     */
    public function call($factoryName, $chunkSize, $chunkId)
    {
        $arguments = array(
            'php',
            $this->pathToBatchJobStartFile,
            $factoryName,
            $chunkId,
            $chunkSize,
            '> /dev/null',
            '&'
        );

        $command = implode(' ', $arguments);

        pcntl_exec($command);
    }
}