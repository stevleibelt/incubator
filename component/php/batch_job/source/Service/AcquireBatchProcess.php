<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\Batchjob\Service;

use Net\Bazzline\Component\BatchJob\Model\Batch;
use Net\Bazzline\Component\BatchJob\Model\StorageInterface;
use Psr\Log\LoggerInterface;

class AcquireBatchProcess
{
    /** @var UniqueBatchIdGeneratorInterface */
    private $uniqueBatchIdGenerator;

    public function acquireBatch(
        int $batchSize,
        LoggerInterface $logger,
        int $numberOfBatchesToAcquire,
        StorageInterface $storage
    ) {
        $uniqueBatchIdGenerator = $this->uniqueBatchIdGenerator;

        $numberOfAcquiredBatches = 0;

        while ($numberOfAcquiredBatches < $numberOfBatchesToAcquire) {
            $batch = new Batch(
                $uniqueBatchIdGenerator->generate(),
                $batchSize
            );

            $storageCouldNotAcquireTheBatch = (
                $storage->acquire($batch) === false
            );

            if ($storageCouldNotAcquireTheBatch) {
                //?
                //$numberOfAcquiredBatches = $numberOfBatchesToAcquire;
                $logger->info(
                    sprintf(
                        'could not acquire batch with id >>%s<< and size of >>%d<<.',
                        $batch->id(),
                        $batch->size()
                    )
                );
                break;
            }

            ++$numberOfAcquiredBatches;
        }
    }
}