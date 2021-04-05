<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-13
 */

require_once(__DIR__ . '/../../../../vendor/autoload.php');
require_once(__DIR__ . '/../../Data.php');

if ($argc < 2) {
    echo ':: Invalid number of arguments provided!' . PHP_EOL;
    echo PHP_EOL;
    echo '   usage: ' . basename(__FILE__) . ' <string: name>' . PHP_EOL;

    exit(0);
}

try {
    $client     = new Redis();
    $idIterator = 0;
    $name       = (string) $argv[1];
    $queue      = 'native_redis';

    $client->connect(
        '127.0.0.1',
        6379,
        0
    );

    echo ':: Connected to the reddis.' . PHP_EOL;

    echo ':: ' . $name . ' Setup done.' . PHP_EOL;
    echo ':: ' . $name . ' Start adding messages to the queue.' . PHP_EOL;

    while (true) {
        $randomNumberOfEntriesToCreate  = rand(5, 500);
        $randomNumberOfSecondsToSleep   = rand(1, 4);

        for ($dataIterator = 0; $dataIterator < $randomNumberOfEntriesToCreate; ++$dataIterator) {
            $data = new Data(
                date('Y-m-d H:i:s'),
                $name . '::' . $idIterator,
                $dataIterator
            );

            $client->rPush(
                $queue,
                $data->toJSON()
            );
        }

        echo ':: ' . $name . ' Created ' . $randomNumberOfEntriesToCreate . ' messages.' . PHP_EOL;
        echo ':: ' . $name . ' Sleeping for ' . $randomNumberOfSecondsToSleep . ' seconds.' . PHP_EOL;

        sleep($randomNumberOfSecondsToSleep);
        ++$idIterator;
    }
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

    if ($client instanceof Redis) {
        $client->disconnect();
    }
}
