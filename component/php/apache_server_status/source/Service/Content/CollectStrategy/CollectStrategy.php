<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Service\Content\CollectStrategy;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatus\Service\Content\Storage\StorageInterface;
use Net\Bazzline\Component\ApacheServerStatus\Service\StateMachine\SectionStateMachine;

class CollectStrategy
{
    /** @var StorageInterface */
    private $collector;

    /** @var array */
    private $lines;

    /** @var SectionStateMachine*/
    private $stateMachine;

    /** @var StringUtility */
    private $stringUtility;

    /**
     * CollectStrategy constructor.
     *
     * @param StorageInterface $collector
     * @param SectionStateMachine $stateMachine
     * @param StringUtility $stringUtility
     */
    public function __construct(
        StorageInterface $collector,
        SectionStateMachine $stateMachine,
        StringUtility $stringUtility
    )
    {
        $this->collector        = $collector;
        $this->lines            = [];
        $this->stateMachine     = $stateMachine;
        $this->stringUtility    = $stringUtility;
    }

    public function collect()
    {
        //begin of dependencies
        $collector      = $this->collector;
        $lines          = $this->lines;
        $stateMachine   = $this->stateMachine;
        $stringUtility  = $this->stringUtility;
        //end of dependencies

        //begin of business logic
        $collector->clear();
        $stateMachine->reset();

        foreach ($lines as $line) {
            if ($stringUtility->startsWith($line, 'Apache Status')) {
                continue;
            } else if ($stringUtility->startsWith($line, 'Current Time:')) {
                $stateMachine->setCurrentStateToStatistic();
            } else if ($stringUtility->startsWith($line, 'Server Details')) {
                $stateMachine->setCurrentStateToDetail();
                continue;
            }

            if ($stateMachine->theCurrentStateIsDetail()) {
                $collector->addDetail($line);
            } else if ($stateMachine->theCurrentStateIsInformation()) {
                $collector->addInformation($line);
            } else if ($stateMachine->theCurrentStateIsScoreboard()) {
                $collector->addScoreboard($line);
            } else if ($stateMachine->theCurrentStateIsStatistic()) {
                $collector->addStatistic($line);
            }

            if ($stringUtility->contains($line, 'requests currently being processed')) {
                $stateMachine->setCurrentStateToScoreboard();
            }
        }
        //end of business logic
    }

    /**
     * @return StorageInterface
     */
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * @param array $lines
     */
    public function setLines(array $lines)
    {
        $this->lines = $lines;
    }
}