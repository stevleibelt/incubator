<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-13
 */

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../Data.php');

if ($argc < 3) {
    echo ':: Invalid number of arguments provided!' . PHP_EOL;
    echo PHP_EOL;
    echo '   usage: ' . basename(__FILE__) . ' <int: chunk_size> <string: fast|medium|slow> [<int: dry-run 1|0>]' . PHP_EOL;

    exit(0);
}

function handleMessage(
    string $message
): bool {
    $canHandleTheMessage = true;

    try {
        $data = Data::fromJSON($message);
    } catch (Exception $exception) {
        echo ':: Error' . PHP_EOL;
        echo '   ' . $exception->getMessage() . PHP_EOL;
        echo '   ' . $exception->getTraceAsString() . PHP_EOL;
        $canHandleTheMessage = false;
    }

    if ($canHandleTheMessage) {
        echo ':: Message created at ' . $data->getCreatedAt() . '.' . PHP_EOL;
        echo ':: Payload is ' . $data->getPayload() . PHP_EOL;
        echo ':: Id ' . $data->getId() . PHP_EOL;
    }

    return $canHandleTheMessage;
}

try {
    $chunkSize  = (int) $argv[1];
    $speed      =  (string) $argv[2];
    $queue      = 'rabbitmq_stomp-php';
    $isDryRun   = (
        ($argc > 3)
            ? ($argv[3] == 1)
            : false
    );

    switch ($speed) {
        case 'slow':
            $sleepForSeconds = 3;
            break;
        case 'medium':
            $sleepForSeconds = 2;
            break;
        case 'fast':
            $sleepForSeconds = 1;
            break;
        default:
            $sleepForSeconds = 0;
            break;
    }

    $client = new Redis();
    $queue  = 'native_redis';

    $client->connect(
        '127.0.0.1',
        6379,
        0
    );

    echo ':: Connected to the reddis.' . PHP_EOL;

    echo ':: Setup done.' . PHP_EOL;
    echo ':: Chunk size is ' . $chunkSize . PHP_EOL;

    while (true) {
        for ($numberOfProcessedChunks = 0; $numberOfProcessedChunks < $chunkSize; ++$numberOfProcessedChunks) {
            $message = $client->blPop(
                [
                    $queue
                ],
                0
            );
            $data = $message[1];    //[0] => queue name, [1] => data

            if ($isDryRun) {
                echo ':: nack the message.' . PHP_EOL;
                $client->rPush(
                    $queue,
                    $data
                );
            } else {
                $success = handleMessage($data);

                if (!$success) {
                    $client->rPush(
                        $queue,
                        $data
                    );
                }
            }
        }

        echo ':: Sleeping for ' . $sleepForSeconds . ' seconds.' . PHP_EOL;
        sleep($sleepForSeconds);
        echo PHP_EOL;
    }
} catch (Throwable $throwable) {
    echo '----' . PHP_EOL;
    echo 'The client made a boh boh.' . PHP_EOL;
    echo PHP_EOL;
    echo 'class: ' . get_class($throwable) . PHP_EOL;
    echo 'message: ' . $throwable->getMessage() . PHP_EOL;
    echo PHP_EOL;
    echo 'stack trace: ' . PHP_EOL;
    echo $throwable->getTraceAsString() . PHP_EOL;
    echo '----' . PHP_EOL;

    if ($client instanceof Redis) {
        $client->disconnect();
    }
}
