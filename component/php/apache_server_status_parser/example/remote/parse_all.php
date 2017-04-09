<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\ReduceDataAbleToArrayInterface;

require __DIR__ . '/../../vendor/autoload.php';

//begin of helper functions
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
//end of helper functions

//begin of dependencies
$factory    = new \Net\Bazzline\Component\Curl\Builder\BuilderFactory();

$fetcher                    = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Fetcher\HttpFetcher(
    $factory->create()
);
$listOfNameToElapsedTime    = [];
$pathToTheExampleFile       = __DIR__ . '/server-status?notable.html';
$stateMachine               = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine\SectionStateMachine();
$stringUtility              = new StringUtility();

$detailListOfLineParser         = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailListOfLineParser(
    new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailLineParser(
        $stringUtility
    )
);
$informationListOfLineParser    = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\InformationListOfLineParser($stringUtility);
$scoreboardListOfLineParser     = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\ScoreboardListOfLineParser();
$statisticListOfLineParser      = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\StatisticListOfLineParser($stringUtility);
$storage                        = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\FullStorage($stringUtility);

$processor  = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Processor\Processor(
    $stateMachine,
    $stringUtility,
    $storage
);
//end of dependencies

//begin of business logic
$fetcher->setUrl('http://testdata.bazzline.net/apache_server_status/index.html');

PHP_Timer::start();
$lines = $fetcher->fetch();
$listOfNameToElapsedTime['fetching']    = PHP_Timer::secondsToTimeString(
    PHP_Timer::stop()
);

PHP_Timer::start();
foreach ($fetcher->fetch() as $line) {
    $processor->process($line);
}
$listOfNameToElapsedTime['processing']    = PHP_Timer::secondsToTimeString(
    PHP_Timer::stop()
);

$storage = $processor->getStorage();

dumpSectionIfThereIsSomeContent($storage->getListOfInformation(), 'Information');
dumpSectionIfThereIsSomeContent($storage->getListOfDetail(), 'Detail');
dumpSectionIfThereIsSomeContent($storage->getListOfScoreboard(), 'Scoreboard');
dumpSectionIfThereIsSomeContent($storage->getListOfStatistic(), 'Statistic');

PHP_Timer::start();
$information                = $informationListOfLineParser->parse($storage->getListOfInformation());
$listOfParsedDetailLines    = $detailListOfLineParser->parse($storage->getListOfDetail());
$scoreboard                 = $scoreboardListOfLineParser->parse($storage->getListOfScoreboard());
$statistic                  = $statisticListOfLineParser->parse($storage->getListOfStatistic());
$listOfNameToElapsedTime['parsing']    = PHP_Timer::secondsToTimeString(
    PHP_Timer::stop()
);

dumpSectionIfThereIsSomeContent(
    $listOfParsedDetailLines,
    'Parsed Detail'
);

dumpSectionIfThereIsSomeContent(
    [
        $information
    ],
    'Parsed Information'
);

dumpSectionIfThereIsSomeContent(
    [
        $scoreboard
    ],
    'Parsed Scoreboard'
);

dumpSectionIfThereIsSomeContent(
    [
        $statistic
    ],
    'Parsed Statistic'
);

foreach ($listOfNameToElapsedTime as $name => $elapsedTime) {
    echo $name . ' took: ' . $elapsedTime . PHP_EOL;
}
//end of business logic
