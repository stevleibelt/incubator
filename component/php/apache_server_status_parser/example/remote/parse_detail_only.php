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
$builder                    = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\RemoteBuilder();
$listOfNameToElapsedTime    = [];
$urlToTheExampleFile        = ($argc > 1)
    ? $argv[1]
    : 'http://testdata.bazzline.net/apache_server_status/index.html';
$stringUtility              = new StringUtility();

$detailListOfLineParser         = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailListOfLineParser(
    new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailLineParser(
        $stringUtility
    )
);
$informationListOfLineParser    = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\InformationListOfLineParser($stringUtility);
$scoreboardListOfLineParser     = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\ScoreboardListOfLineParser();
$statisticListOfLineParser      = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\StatisticListOfLineParser($stringUtility);
//end of dependencies

//begin of business logic
$builder->setUrlToTheApacheStatusFileToParseUpfront($urlToTheExampleFile);
$builder->selectParseModeDetailOnlyUpfront();
$builder->build();

$storage    = $builder->andGetStorageAfterTheBuild();

dumpSectionIfThereIsSomeContent($storage->getListOfDetail(), 'Detail');

PHP_Timer::start();
$listOfParsedDetailLines    = $detailListOfLineParser->parse($storage->getListOfDetail());
$listOfNameToElapsedTime['parsing'] = PHP_Timer::secondsToTimeString(
    PHP_Timer::stop()
);

dumpSectionIfThereIsSomeContent(
    $listOfParsedDetailLines,
    'Parsed Detail'
);

foreach ($listOfNameToElapsedTime as $name => $elapsedTime) {
    echo $name . ' took: ' . $elapsedTime . PHP_EOL;
}
//end of business logic
