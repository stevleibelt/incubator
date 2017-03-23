<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */

require __DIR__ . '/vendor/autoload.php';
/**
 * @param array $array
 * @param string $prefix
 */
function dumpArray(array $array, $prefix = '  ')
{
    foreach ($array as $item => $value) {
        if ($value instanceof \Net\Bazzline\Component\ApacheServerStatus\DomainModel\Worker) {
            echo $prefix . $item . PHP_EOL;
            dumpArray($value->toArray(), str_repeat($prefix, 2));
        } else if (is_array($value)) {
            echo $prefix . $item . PHP_EOL;
            dumpArray($value, str_repeat($prefix, 2));
        } else {
            echo $prefix . $item . ': ' . $value . PHP_EOL;
        }
    }
}

/**
 * @param array $lines
 * @param string $name
 */
function dumpSectionIfThereIsSomeContent(array $lines, $name)
{
    if (!empty($lines)) {
        echo '==== ' . $name .' ====' . PHP_EOL;
        echo PHP_EOL;

        dumpArray($lines);

        echo PHP_EOL;
    }
}

/**
 * @param array $lines
 * @param \JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility $stringUtility
 *
 * @return array
 */
function parseLinesOfDetailIntoAnArray(
    array $lines,
    \JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility $stringUtility
)
{
    $parsedLines = [];

    foreach ($lines as $line) {
        if ($stringUtility->startsWith($line, 'Server ')) {
            $asArray = explode(' ', $line);

            /*
            echo $line . PHP_EOL;
            print_r($asArray);
            echo PHP_EOL;
            */
            $parsedLines[] = [
                'pid'                   => $asArray[2],
                'status'                => $asArray[4],
                'ip_address'            => $asArray[15],
                'http_method'           => $asArray[16],
                'uri_authority'         => (isset($asArray[19]) ? $asArray[19] : $asArray[18]),
                'uri_path_with_query'   => $asArray[17],
                'worker'                => new \Net\Bazzline\Component\ApacheServerStatus\DomainModel\Worker(
                    $asArray[16],
                    $asArray[15],
                    (int) $asArray[2],
                    $asArray[4],
                    (isset($asArray[19]) ? $asArray[19] : $asArray[18]),
                    $asArray[17]
                ),
                'line'                  => $line,
                'size'                  => count($asArray)
            ];
        }
        //$matches = [];
        //preg_match('/(\([0-9]{1,}\)).*/', $line, $matches);

        //print_r($matches);
    }

    return $parsedLines;
}

//this file contains my first WIP draft of implementing the simple information parsing

$pathToTheExampleFile   = __DIR__ . '/example/server-status?notable.html';

$fetcher        = new \Net\Bazzline\Component\ApacheServerStatus\Service\Fetcher\FileFetcher();
$stateMachine   = new \Net\Bazzline\Component\ApacheServerStatus\Service\StateMachine\SectionStateMachine();
$stringUtility  = new \JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility();

$collector  = new \Net\Bazzline\Component\ApacheServerStatus\Service\Collector\DetailOnlyContentCollector($stringUtility);
$strategy   = new \Net\Bazzline\Component\ApacheServerStatus\Service\CollectStrategy\CollectStrategy(
    $collector,
    $stateMachine,
    $stringUtility
);

//cleanup
$fetcher->setPath($pathToTheExampleFile);

$lines = $fetcher->fetch();

$strategy->setLines($lines);
$strategy->collect();
$collector = $strategy->getCollector();

dumpSectionIfThereIsSomeContent($collector->getListOfInformation(), 'Information');
dumpSectionIfThereIsSomeContent($collector->getListOfDetail(), 'Detail');
dumpSectionIfThereIsSomeContent($collector->getListOfScoreboard(), 'Scoreboard');
dumpSectionIfThereIsSomeContent($collector->getListOfStatistic(), 'Statistic');

dumpSectionIfThereIsSomeContent(
    parseLinesOfDetailIntoAnArray(
        $collector->getListOfDetail(),
        $stringUtility
    ),
    'Parsed Detail'
);
