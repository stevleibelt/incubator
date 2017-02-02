<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */

require __DIR__ . '/vendor/autoload.php';

function dumpArray(array $array, $prefix = '  ')
{
    foreach ($array as $item => $value) {
        if (is_array($value)) {
            echo $prefix . $item . PHP_EOL;
            //print_r($value);
            dumpArray($value, str_repeat($prefix, 2));
        } else {
            echo $prefix . $item . ': ' . $value . PHP_EOL;
        }
    }
}

function dumpSectionIfThereIsSomeContent(array $lines, $name)
{
    if (!empty($lines)) {
        echo '==== ' . $name .' ====' . PHP_EOL;
        echo PHP_EOL;

        dumpArray($lines);

        echo PHP_EOL;
    }
}

function parseLinesOfDetailIntoAnArray($lines, \Net\Bazzline\Component\ApacheServerStatus\Tool\StringTool $stringTool)
{
    $parsedLines = [];

    foreach ($lines as $line) {
        if ($stringTool->startsWith($line, 'Server ')) {
            $asArray = explode(' ', $line);

            /*
            echo $line . PHP_EOL;
            print_r($asArray);
            echo PHP_EOL;
            */
            $parsedLines[] = [
                'pid'                   => $asArray[2],
                'status'                => $asArray[4],
                'http_method'           => $asArray[16],
                'uri_authority'         => (isset($asArray[19]) ? $asArray[19] : $asArray[18]),
                'uri_path_with_query'   => $asArray[17],
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

$fetcher        = new \Net\Bazzline\Component\ApacheServerStatus\Fetcher\FileFetcher();
$stateMachine   = new \Net\Bazzline\Component\ApacheServerStatus\StateMachine\SectionStateMachine();
$stringTool     = new \Net\Bazzline\Component\ApacheServerStatus\Tool\StringTool();

//$collector  = new \Net\Bazzline\Component\ApacheServerStatus\Collector\FullContentCollector($stringTool);
$collector  = new \Net\Bazzline\Component\ApacheServerStatus\Collector\DetailOnlyContentCollector($stringTool);
$strategy   = new \Net\Bazzline\Component\ApacheServerStatus\CollectStrategy\CollectStrategy(
    $collector,
    $stateMachine,
    $stringTool
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
        $stringTool
    ),
    'Parsed Detail'
);
