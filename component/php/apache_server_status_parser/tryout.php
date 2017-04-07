<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\ReduceDataAbleToArrayInterface;

require __DIR__ . '/vendor/autoload.php';
/**
 * @param array $array
 * @param string $prefix
 */
function dumpArray(array $array, $prefix = '  ')
{
    foreach ($array as $item => $value) {
        if ($value instanceof ReduceDataAbleToArrayInterface) {
            echo $prefix . $item . PHP_EOL;
            dumpArray($value->reduceDataToArray(), str_repeat($prefix, 2));
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

//this file contains my first WIP draft of implementing the simple information parsing

$pathToTheExampleFile   = __DIR__ . '/example/server-status?notable.html';

$fetcher            = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Fetcher\FileFetcher();
$stateMachine       = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine\SectionStateMachine();
$stringUtility      = new StringUtility();

//$storage    = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\DetailOnlyStorage($stringUtility);
$detailLineParser               = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailLineParser($stringUtility);
$informationListOfLineParser    = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\InformationListOfLineParser($stringUtility);
$scoreboardListOfLineParser     = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\ScoreboardListOfLineParser($stringUtility);
$statisticListOfLineParser      = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\StatisticListOfLineParser($stringUtility);
$storage                        = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\FullStorage($stringUtility);

$processor  = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Processor\Processor(
    $stateMachine,
    $stringUtility,
    $storage
);

//cleanup
$fetcher->setPath($pathToTheExampleFile);

$lines = $fetcher->fetch();

foreach ($fetcher->fetch() as $line) {
    $processor->process($line);
}

$storage = $processor->getStorage();

dumpSectionIfThereIsSomeContent($storage->getListOfInformation(), 'Information');
dumpSectionIfThereIsSomeContent($storage->getListOfDetail(), 'Detail');
dumpSectionIfThereIsSomeContent($storage->getListOfScoreboard(), 'Scoreboard');
dumpSectionIfThereIsSomeContent($storage->getListOfStatistic(), 'Statistic');

$information                = $informationListOfLineParser->parse($storage->getListOfInformation());
$scoreboard                 = $scoreboardListOfLineParser->parse($storage->getListOfScoreboard());
$statistic                  = $statisticListOfLineParser->parse($storage->getListOfStatistic());
$listOfParsedDetailLines    = [];

foreach ($storage->getListOfDetail() as $line) {
    try {
        $listOfParsedDetailLines[]  = $detailLineParser->parse($line);
    } catch (InvalidArgumentException $invalidArgumentException) {
        //echo get_class($detailLineParser) . ' could not parse the following line:' . PHP_EOL;
        //echo '    ' . $line . PHP_EOL;
        //echo $invalidArgumentException->getMessage() . PHP_EOL;
    }
}

dumpSectionIfThereIsSomeContent(
    [
        $scoreboard
    ],
    'Parsed Scoreboard'
);

/*
dumpSectionIfThereIsSomeContent(
    [
        $statistic
    ],
    'Parsed Statistic'
);

dumpSectionIfThereIsSomeContent(
    [
        $information
    ],
    'Parsed Information'
);

dumpSectionIfThereIsSomeContent(
    $listOfParsedDetailLines,
    'Parsed Detail'
);
*/
