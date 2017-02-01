<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */

require __DIR__ . '/vendor/autoload.php';

function dumpSection(array $lines, $name)
{
    echo '==== ' . $name .' ====' . PHP_EOL;
    echo PHP_EOL;

    foreach ($lines as $line) {
        echo $line . PHP_EOL;
    }

    echo PHP_EOL;
}

//this file contains my first WIP draft of implementing the simple information parsing

$pathToTheExampleFile   = __DIR__ . '/example/server-status?notable.html';

$fetcher        = new \Net\Bazzline\Component\ApacheServerStatus\Fetcher\FileFetcher();
$stateMachine   = new \Net\Bazzline\Component\ApacheServerStatus\StateMachine\SectionStateMachine();
$stringTool     = new \Net\Bazzline\Component\ApacheServerStatus\Tool\StringTool();

$collector  = new \Net\Bazzline\Component\ApacheServerStatus\Collector\FullContentCollector($stringTool);
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

dumpSection($collector->getListOfInformation(), 'Information');
dumpSection($collector->getListOfDetail(), 'Detail');
dumpSection($collector->getListOfScoreboard(), 'Scoreboard');
dumpSection($collector->getListOfStatistic(), 'Statistic');
