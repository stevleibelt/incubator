<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */

class ContentCollection
{
    /** @var null|int */
    private $currentIndexKeyForListOfDetail;

    /** @var array */
    private $listOfDetail;

    /** @var array */
    private $listOfInformation;

    /** @var array */
    private $listOfScoreboard;

    /** @var array */
    private $listOfStatistic;

    /** @var StringTool */
    private $stringTool;

    /**
     * ContentCollection constructor.
     *
     * @param StringTool $stringTool
     */
    public function __construct(StringTool $stringTool)
    {
        $this->currentIndexKeyForListOfDetail  = null;

        $this->listOfDetail         = [];
        $this->listOfInformation    = [];
        $this->listOfScoreboard     = [];
        $this->listOfStatistic      = [];

        $this->stringTool   = $stringTool;
    }

    /**
     * @param string $line
     */
    public function addDetail($line)
    {
        $stringTool = $this->stringTool;

        if (is_null($this->currentIndexKeyForListOfDetail)) {
            ++$this->currentIndexKeyForListOfDetail;
        } else {
            if ($stringTool->startsWith($line, 'Server')) {
                ++$this->currentIndexKeyForListOfDetail;
            }
        }

        if (isset($this->listOfDetail[$this->currentIndexKeyForListOfDetail])) {
            $this->listOfDetail[$this->currentIndexKeyForListOfDetail] .= $line;
        } else {
            $this->listOfDetail[$this->currentIndexKeyForListOfDetail] = $line;
        }
    }

    /**
     * @param string $line
     */
    public function addInformation($line)
    {
        $this->listOfInformation[] = $line;
    }

    /**
     * @param string $line
     */
    public function addScoreboard($line)
    {
        $this->listOfScoreboard[] = $line;
    }

    /**
     * @param string $line
     */
    public function addStatistic($line)
    {
        $this->listOfStatistic[] = $line;
    }

    /**
     * @return array
     */
    public function getListOfDetail()
    {
        return $this->listOfDetail;
    }

    /**
     * @return array
     */
    public function getListOfInformation()
    {
        return $this->listOfInformation;
    }

    /**
     * @return array
     */
    public function getListOfScoreboard()
    {
        return $this->listOfScoreboard;
    }

    /**
     * @return array
     */
    public function getListOfStatistic()
    {
        return $this->listOfStatistic;
    }
}

class SectionStateMachine
{
    /** @var string */
    private $currentState;

    public function __construct()
    {
        $this->setCurrentStateToInformation();
    }

    public function setCurrentStateToDetail()
    {
        $this->currentState = 'detail';
    }

    public function setCurrentStateToInformation()
    {
        $this->currentState = 'information';
    }

    public function setCurrentStateToScoreboard()
    {
        $this->currentState = 'scoreboard';
    }

    public function setCurrentStateToStatistic()
    {
        $this->currentState = 'statistic';
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsDetail()
    {
        return ($this->currentState === 'detail');
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsInformation()
    {
        return ($this->currentState === 'information');
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsScoreboard()
    {
        return ($this->currentState === 'scoreboard');
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsStatistic()
    {
        return ($this->currentState === 'statistic');
    }
}

class StringTool
{
    /**
     * @param string $string
     * @param string $search
     * @return boolean
     */
    public function contains($string, $search)
    {
        if (strlen($search) == 0) {
            $contains = false;
        } else {
            $contains = !(strpos($string, $search) === false);
        }

        return $contains;
    }

    /**
     * @param string $string
     * @param string $start
     * @param string $end
     * @return null|string
     */
    public function crop($string, $start, $end)
    {
        $positionOfTheStart         = strpos($string, $start);
        $positionOfTheStartIsValid  = ($positionOfTheStart !== false);
        $section                    = null;

        if ($positionOfTheStartIsValid) {
            $positionOfTheStartWithLengthOfStart    = $positionOfTheStart + strlen($start);
            $lengthOfTheSection                     = strpos($string, $end, $positionOfTheStartWithLengthOfStart) - $positionOfTheStartWithLengthOfStart;   //start searching for $end at $positionOfTheStartWithLengthOfStart and subtract the length of the string including the end of $start

            $section = substr($string, $positionOfTheStartWithLengthOfStart, $lengthOfTheSection);
        }

        return $section;
    }

    /**
     * @param string $string
     * @param string $start
     *
     * @return bool
     */
    public function startsWith($string, $start)
    {
         return (strncmp($string, $start, strlen($start)) === 0);
    }
}

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
$stateMachine           = new SectionStateMachine();
$stringTool             = new StringTool();

$contentCollection      = new ContentCollection($stringTool);

//data fetching will be done elsewhere

//cleanup
$contentAsString        = strip_tags(file_get_contents($pathToTheExampleFile));
$contentAsArray         = explode(PHP_EOL, $contentAsString);

$lines = array_filter(
    $contentAsArray,
    function ($item) {
        return (strlen(trim($item)) > 0);
    }
);

//split into sections information, statistic, scoreboard and details

foreach ($lines as $line) {
    if ($stringTool->startsWith($line, 'Apache Status')) {
        continue;
    } else if ($stringTool->startsWith($line, 'Current Time:')) {
        $stateMachine->setCurrentStateToStatistic();
    } else if ($stringTool->startsWith($line, 'Server Details')) {
        $stateMachine->setCurrentStateToDetail();
        continue;
    }

    if ($stateMachine->theCurrentStateIsDetail()) {
        $contentCollection->addDetail($line);
    } else if ($stateMachine->theCurrentStateIsInformation()) {
        $contentCollection->addInformation($line);
    } else if ($stateMachine->theCurrentStateIsScoreboard()) {
        $contentCollection->addScoreboard($line);
    } else if ($stateMachine->theCurrentStateIsStatistic()) {
        $contentCollection->addStatistic($line);
    }

    if ($stringTool->contains($line, 'requests currently being processed')) {
        $stateMachine->setCurrentStateToScoreboard();
    }
}

dumpSection($contentCollection->getListOfInformation(), 'Information');
dumpSection($contentCollection->getListOfDetail(), 'Detail');
dumpSection($contentCollection->getListOfScoreboard(), 'Scoreboard');
dumpSection($contentCollection->getListOfStatistic(), 'Statistic');
