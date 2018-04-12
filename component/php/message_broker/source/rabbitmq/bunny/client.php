<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-12
 */

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once 'Data.php';

if ($argc < 3) {
    echo ':: Invalid number of arguments provided!' . PHP_EOL;
    echo PHP_EOL;
    echo '   usage: ' . basename(__FILE__) . ' <int: chunk_size> <string: fast|medium|slow>' . PHP_EOL;

    exit(0);
}

function handleMessage(
    string $message
): bool {
    $canHandleTheMessage = true;

    try {
        $data = Data::fromJSON($message);
    } catch (Exception $exception) {
        $canHandleTheMessage = false;
    }

    if ($canHandleTheMessage) {
        echo ':: Message created at ' . $data->getCreatedAt() . '.' . PHP_EOL;
        echo ':: Payload is ' . $data->getPayload() . PHP_EOL;
        echo ':: Id ' . $data->getId() . PHP_EOL;
        echo PHP_EOL;
    }

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

    $client = new Client($connection);
    $client->connect();

    echo ':: Connected to the rabbitmq.' . PHP_EOL;

    $channel = $client->channel();
    $channel->queueDeclare('the_example_queue');
    $channel->qos(
        0,
        $chunkSize
    );

    echo ':: Setup done.' . PHP_EOL;
    echo ':: Chunk size is ' . $chunkSize . PHP_EOL;

    $channel->run(
        function (Message $message, Channel $channel, Client $client) use ($speed) {

            $data = (string) $message->content;
            $success = handleMessage($data);

            switch ($speed) {
                case 'slow':
                    sleep (3);
                    break;
                case 'medium':
                    sleep (2);
                    break;
                case 'fast':
                    sleep (1);
                    break;
                default:
                    break;
            }

            if ($success) {
                $channel->ack($message);
                return;
            }

            $channel->nack($message);
        },
        'the_example_queue'
    );
} catch (Throwable $throwable) {
    echo '----' . PHP_EOL;
    echo 'The server made a bum bum.' . PHP_EOL;
    echo PHP_EOL;
    echo 'class: ' . get_class($throwable) . PHP_EOL;
    echo 'message: ' . $throwable->getMessage() . PHP_EOL;
    echo PHP_EOL;
    echo 'stack trace: ' . PHP_EOL;
    echo $throwable->getTraceAsString() . PHP_EOL;
    echo '----' . PHP_EOL;
}

