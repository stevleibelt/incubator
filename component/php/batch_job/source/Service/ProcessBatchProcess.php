<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\Batchjob\Service;

use Exception;
use Net\Bazzline\Component\BatchJob\Model\Batch;
use Net\Bazzline\Component\BatchJob\Model\JobInterface;
use Net\Bazzline\Component\BatchJob\Model\StorageInterface;
use Psr\Log\LoggerInterface;

class ProcessBatchProcess
{
    public function processBatch(
        Batch $batch,
        JobInterface $job,
        LoggerInterface $logger,
        StorageInterface $storage
    ) {
        try {
            $job->execute(
                $storage->get(
                    $batch
                )
            );

            $storage->delete(
                $batch
            );
        } catch (Exception $exception) {
            $logger->error(
                sprintf(
                    'caught exception of class >>%s<< while trying to process batch with id >>%s<< and size of >>%d<<.',
                    get_class($exception),
                    $batch->id(),
                    $batch->size()
                )
            );
            $storage->release(
                $batch
            );
        }
    }
}