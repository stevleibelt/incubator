<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

use Net\Bazzline\Component\MessageQueue\Broker\BrokerInterface;
use Net\Bazzline\Component\MessageQueue\Broker\RabbitMQ\Bunny\BunnyBroker;
use Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\RedisBroker;

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/ExampleBrokerBuilder.php');

if ($argc < 4) {
    echo ':: Invalid number of arguments provided!' . PHP_EOL;
    echo PHP_EOL;
    echo '   usage: ' . basename(__FILE__) . ' <string: broker (rabbitmq-bunny|redis-native)> <string: identifier> <string: queue_name> [<int: number_of_messages_to_create>]' . PHP_EOL;

    exit(0);
}

function createAndPublishMessage(
    BrokerInterface $broker,
    string $identifier
) {
    $broker->publish(
        json_encode(
            [
                'created_at'    => date('Y-m-d H:i:s'),
                'producer'      => $identifier
            ]
        )
    );
}

try {
    $brokerBuilder  = new ExampleBrokerBuilder();
    $brokerClassName    = (string) $argv[1];
    $identifier         = (string) $argv[2];
    $queueName          = (string) $argv[3];

    if ($argc > 4) {
        $numberOfMessagesToCreate = (int) $argv[4];
    } else {
        $numberOfMessagesToCreate = null;
    }

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
    $brokerBuilder->setIsDurable(
        true
    );
    $brokerBuilder->setQueueName(
        $queueName
    );

    $broker = $brokerBuilder->build();

    $broker->connect();

    if (is_null($numberOfMessagesToCreate)) {
        echo ':: Creating endless amount of messages.' . PHP_EOL;

        while (true) {
            createAndPublishMessage(
                $broker,
                $identifier
            );
        }
    } else {
        echo ':: Creating ' . $numberOfMessagesToCreate . ' messages.' . PHP_EOL;

        for ($numberOfMessagesToCreateIterator = 0; $numberOfMessagesToCreateIterator < $numberOfMessagesToCreate; ++$numberOfMessagesToCreateIterator) {
            createAndPublishMessage(
                $broker,
                $identifier
            );
        }
    }

    $broker->disconnect();
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
