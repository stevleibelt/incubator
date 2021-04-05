<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-12
 */

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;

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

    /*
    if ($canHandleTheMessage) {
        echo ':: Message created at ' . $data->getCreatedAt() . '.' . PHP_EOL;
        echo ':: Payload is ' . $data->getPayload() . PHP_EOL;
        echo ':: Id ' . $data->getId() . PHP_EOL;
    }
    */

    return $canHandleTheMessage;
}

try {
    $connection = [
        'host'      => 'localhost',
        'vhost'     => '/',
        'user'      => 'guest',
        'password'  => 'guest'
    ];
    $chunkSize  = (int) $argv[1];
    $speed      =  (string) $argv[2];
    $queue      = 'rabbitmq_bunny';
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

    $client = new Client($connection);
    $client->connect();

    echo ':: Connected to the rabbitmq.' . PHP_EOL;

    $channel = $client->channel();
    $channel->queueDeclare(
        $queue,
        false,
        true
    );
    $channel->qos(
        0,
        $chunkSize
    );

    echo ':: Setup done.' . PHP_EOL;
    echo ':: Chunk size is ' . $chunkSize . PHP_EOL;

    $channel->run(
        function (Message $message, Channel $channel, Client $client) use ($speed, $sleepForSeconds, $isDryRun) {
            $data = (string) $message->content;

            if ($isDryRun) {
                echo ':: nack the message.' . PHP_EOL;
                echo '   ' . $data . PHP_EOL;
                $channel->nack($message);
            } else {
                if ($message->redelivered) {
                    echo ':: Dealing with redelivered message.' . PHP_EOL;
                }
                $success = handleMessage($data);

                if ($success) {
                    echo ':: ack the message.' . PHP_EOL;
                    echo '   ' . $data . PHP_EOL;
                    $channel->ack($message);
                } else {
                    echo ':: nack the message.' . PHP_EOL;
                    echo '   ' . $data . PHP_EOL;
                    $channel->nack($message);
                }
            }

            echo ':: Sleeping for ' . $sleepForSeconds . ' seconds.' . PHP_EOL;
            sleep($sleepForSeconds);
            echo PHP_EOL;
        },
       $queue
    );
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

    if ($client instanceof Client) {
        $client->disconnect();
    }
}

