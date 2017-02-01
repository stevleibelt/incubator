<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatus\CollectContentStrategy;

use Net\Bazzline\Component\ApacheServerStatus\Collector\ContentCollectorInterface;
use Net\Bazzline\Component\ApacheServerStatus\StateMachine\SectionStateMachine;
use Net\Bazzline\Component\ApacheServerStatus\Tool\StringTool;

class CollectContentStrategy
{
    /** @var ContentCollectorInterface */
    private $collector;

    /** @var array */
    private $lines;

    /** @var SectionStateMachine*/
    private $stateMachine;

    /** @var StringTool */
    private $stringTool;

    /**
     * CollectContentStrategy constructor.
     *
     * @param ContentCollectorInterface $collector
     * @param SectionStateMachine $stateMachine
     * @param StringTool $stringTool
     */
    public function __construct(ContentCollectorInterface $collector, SectionStateMachine $stateMachine, StringTool $stringTool)
    {
        $this->collector    = $collector;
        $this->lines        = [];
        $this->stateMachine = $stateMachine;
        $this->stringTool   = $stringTool;
    }

    public function collect()
    {
        //begin of dependencies
        $collector      = $this->collector;
        $lines          = $this->lines;
        $stateMachine   = $this->stateMachine;
        $stringTool     = $this->stringTool;
        //end of dependencies

        //begin of business logic
        $collector->clear();
        $stateMachine->reset();

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
                $collector->addDetail($line);
            } else if ($stateMachine->theCurrentStateIsInformation()) {
                $collector->addInformation($line);
            } else if ($stateMachine->theCurrentStateIsScoreboard()) {
                $collector->addScoreboard($line);
            } else if ($stateMachine->theCurrentStateIsStatistic()) {
                $collector->addStatistic($line);
            }

            if ($stringTool->contains($line, 'requests currently being processed')) {
                $stateMachine->setCurrentStateToScoreboard();
            }
        }
        //end of business logic
    }

    /**
     * @return ContentCollectorInterface
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