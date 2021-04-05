<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-13
 */

require_once(__DIR__ . '/../../../../vendor/autoload.php');
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

    $client = new Stomp\Client(
        new \Stomp\Network\Connection(
            'tcp://localhost:61613'
        )
    );
    $client->setLogin('guest', 'guest');
    $client->setVhostname('/');
    $client->setSync(false);
    $client->connect();

    $stomp = new \Stomp\SimpleStomp(
        $client
    );
    $stomp->subscribe($queue);

    echo ':: Connected to the rabbitmq.' . PHP_EOL;

    echo ':: Setup done.' . PHP_EOL;
    echo ':: Chunk size is ' . $chunkSize . PHP_EOL;

    while (true) {
        for ($numberOfProcessedChunks = 0; $numberOfProcessedChunks < $chunkSize; ++$numberOfProcessedChunks) {
            $frame = $stomp->read();

            if ($frame->isErrorFrame()) {
                echo ':: Something is wrong!' . PHP_EOL;
                echo '   ' . var_export($frame, true) . PHP_EOL;
                echo PHP_EOL;
            } else {
                if ($isDryRun) {
                    echo ':: nack the frame.' . PHP_EOL;
                } else {
                    $data = (string) $frame->getBody();
                    $success = handleMessage($data);

                    if ($success) {
                        $stomp->ack($frame);
                    } else {
                        $stomp->nack($frame);
                    }
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

    if ($client instanceof \Stomp\Client) {
        $client->disconnect();
    }
}
