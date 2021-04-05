<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

use Net\Bazzline\Component\MessageQueue\Broker\MessageInterface;
use Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny\BunnyBroker;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\RedisBroker;

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/ExampleBrokerBuilder.php');

if ($argc < 3) {
    echo ':: Invalid number of arguments provided!' . PHP_EOL;
    echo PHP_EOL;
    echo '   usage: ' . basename(__FILE__) . ' <string: broker (rabbitmq-bunny|redis-native)> <string: queue_name> [<int: chunk_size>] [<string: fast|medium|slow|full-throttle>] [<int: dry-run 1|0>]' . PHP_EOL;

    exit(0);
}

try {
    $brokerBuilder      = new ExampleBrokerBuilder();
    $brokerClassName    = (string) $argv[1];
    $chunkSize          = (isset($argv[3])) ? (int) $argv[3] : 1;
    $queueName          = (string) $argv[2];
    $speed              = (isset($argv[4])) ? (string) $argv[4] : 'full-throttle';
    $isDryRun           = (isset($argv[5])) ? (bool) $argv[5] : false;

    switch ($brokerClassName) {
        case 'rabbitmq-bunny':
            $brokerBuilder->setBrokerClassName(
                BunnyBroker::class
            );
            break;
        case 'redis-native':
            $brokerBuilder->setBrokerClassName(
                RedisBroker::class
            );
            break;
    }
    $brokerBuilder->setChunkSize(
        $chunkSize
    );
    $brokerBuilder->setIsDurable(
        true
    );
    $brokerBuilder->setQueueName(
        $queueName
    );

    $broker = $brokerBuilder->build();

    $broker->connect();

    $broker->subscribe(
        function (MessageInterface $message) use ($broker, $speed, $isDryRun) {
            $data = json_decode($message->toString());

            echo ':: ' . var_export($data, true) . PHP_EOL;

            switch($speed) {
                case 'fast':
                    sleep(1);
                    break;
                case 'medium':
                    sleep(2);
                    break;
                case 'slow':
                    sleep(3);
                    break;
                case 'full-throttle':
                default:
                    break;
            }

            if ($isDryRun) {
                $broker->dismiss(
                    $message
                );
            } else {
                $broker->acknowledge(
                    $message
                );
            }
        }
    );
} catch (Throwable $throwable) {
    echo '----' . PHP_EOL;
    echo 'The server made a boh boh.' . PHP_EOL;
    echo PHP_EOL;
    echo 'class: ' . get_class($throwable) . PHP_EOL;
    echo 'message: ' . $throwable->getMessage() . PHP_EOL;
    echo PHP_EOL;
    echo 'stack trace: ' . PHP_EOL;
    echo $throwable->getTraceAsString() . PHP_EOL;
    echo '----' . PHP_EOL;

    if ($broker instanceof BunnyBroker) {
        $broker->disconnect();
    }
}
