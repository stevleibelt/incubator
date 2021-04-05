<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2019-02-11
 */


class CrontabManager
{
    /** @var string */
    private $filePathFullDump;

    /** @var string */
    private $filePathSectionDump;

    /** @var string */
    private $filePathSectionRendered;

    /** @var string */
    private $filePathTemplate;

    /** @var string */
    private $filePathUpdatedDump;

    /** @var array */
    private $mapOfTemplateKeyToValue;

    /** @var array */
    private $sectionUniqueIdentifier;

    public function __construct(
        string $filePathFullDump,
        string $filePathSectionDump,
        string $filePathSectionRendered,
        string $filePathTemplate,
        string $filePathUpdatedDump,
        array $mapOfTemplateKeyToValue,
        string $sectionUniqueIdentifier
    ) {
        $this->filePathFullDump         = $filePathFullDump;
        $this->filePathSectionDump      = $filePathSectionDump;
        $this->filePathSectionRendered  = $filePathSectionRendered;
        $this->filePathTemplate         = $filePathTemplate;
        $this->filePathUpdatedDump      = $filePathUpdatedDump;
        $this->mapOfTemplateKeyToValue  = $mapOfTemplateKeyToValue;
        $this->sectionUniqueIdentifier  = $sectionUniqueIdentifier;
    }

    /**
     * @throws RuntimeException
     */
    public function audit()
    {
        $dumpFullCronTab    = (!file_exists($this->filePathFullDump));
        $dumpSectionCronTab = (!file_exists($this->filePathSectionDump));

        if ($dumpFullCronTab) {
            echo ':: Creating file >>' . $this->filePathFullDump . '<<.' . PHP_EOL;
            $this->dumpFullCronTab();
        }

        if ($dumpSectionCronTab) {
            echo ':: Creating file >>' . $this->filePathSectionDump . '<<.' . PHP_EOL;
            $this->createSectionCronTag();
        }

        echo ':: Creating file >>' . $this->filePathSectionRendered . '<<.' . PHP_EOL;
        $this->renderSectionTemplate();

        echo ':: Dumping diff.' . PHP_EOL;
        echo '   file one >>' . $this->filePathSectionDump . '<< file two >>' . $this->filePathSectionRendered . '<<.' . PHP_EOL;
        foreach ($this->diff($this->filePathSectionDump, $this->filePathSectionRendered) as $line) {
            echo $line . PHP_EOL;
        }
    }

    /**
     * @throws RuntimeException
     */
    public function update()
    {
        $dumpFullCronTab    = (!file_exists($this->filePathFullDump));
        $dumpSectionCronTab = (!file_exists($this->filePathSectionDump));

        if ($dumpFullCronTab) {
            echo ':: Creating file >>' . $this->filePathFullDump . '<<.' . PHP_EOL;
            $this->dumpFullCronTab();
        }

        if ($dumpSectionCronTab) {
            echo ':: Creating file >>' . $this->filePathFullDump . '<<.' . PHP_EOL;
            $this->createSectionCronTag();
        }

        if (!empty($this->diff($this->filePathSectionDump, $this->filePathSectionRendered))) {
            echo ':: Creating file >>' . $this->filePathUpdatedDump . '<<.' . PHP_EOL;
            $listOfUpdatedLine = $this->replaceSectionContent(
                $this->readFileAsArray($this->filePathFullDump),
                $this->readFileAsArray($this->filePathSectionRendered),
                $this->sectionUniqueIdentifier
            );

            $this->writeToFileFromArray(
                $this->filePathUpdatedDump,
                $listOfUpdatedLine
            );
        }
    }

    public function deleteFullCronTab()
    {
        $command = '/usr/bin/env crontab -r';

        $this->executeCommand(
            $command
        );
    }

    public function disableFullCronTab()
    {
        $this->dumpFullCronTab();
        $this->deleteFullCronTab();
    }

    public function disableSectionCronTab()
    {
        $this->dumpFullCronTab();
        $this->createSectionCronTag();
        $listOfUpdatedLine = $this->replaceSectionContent(
            $this->readFileAsArray($this->filePathFullDump),
            [],
            $this->sectionUniqueIdentifier
        );

        $this->writeToFileFromArray(
            $this->filePathUpdatedDump,
            $listOfUpdatedLine
        );

        $this->loadUpdatedCronTab();
    }

    /**
     * @throws RuntimeException
     */
    public function dumpFullCronTab()
    {
        $command = '/usr/bin/env crontab -l';

        $listOfLine = $this->executeCommand(
            $command
        );

        $this->writeToFileFromArray(
            $this->filePathFullDump,
            $listOfLine
        );
    }

    public function enableFullCronTab()
    {
        $this->loadFullCronTab();
    }

    public function enableSectionCronTab()
    {
        $this->update();
        $this->loadUpdatedCronTab();
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function loadFullCronTab()
    {
        $this->loadToCronTab(
            $this->filePathFullDump
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function loadUpdatedCronTab()
    {
        $this->loadToCronTab(
            $this->filePathUpdatedDump
        );
    }

    /**
     * @throws RuntimeException
     */
    private function createSectionCronTag()
    {
        $listOfAllLine = $this->readFileAsArray(
            $this->filePathFullDump
        );

        $listOfSectionLine = $this->sliceSection(
            $listOfAllLine,
            $this->sectionUniqueIdentifier
        );

        $this->writeToFileFromArray(
            $this->filePathSectionDump,
            $listOfSectionLine
        );
    }

    /**
     * @param string $filePathOne
     * @param string $filePathTwo
     * @return array
     * @throws RuntimeException
     */
    private function diff(
        string $filePathOne,
        string $filePathTwo
    ) {
        $command = '/usr/bin/env diff ' . $filePathOne . ' ' . $filePathTwo;

        $listOfLine = $this->executeCommand(
            $command,
            false
        );

        return $listOfLine;
    }

    /**
     * @param string $command
     * @param bool $evaluateReturnCode
     * @return array
     * @throws RuntimeException
     */
    private function executeCommand(
        string $command,
        bool $evaluateReturnCode = true
    ) : array {
        $listOfLine = [];
        $returnCode = null;

        exec(
            $command,
            $listOfLine,
            $returnCode
        );

        if ($evaluateReturnCode) {
            $this->throwRuntimeExceptionIfReturnCodeIsGreaterZero(
                $command,
                $listOfLine,
                $returnCode
            );
        }

        return $listOfLine;
    }

    /**
     * @param string $filePath
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    private function loadToCronTab(
        string $filePath
    ) {
        if (file_exists($filePath)) {
            $command    = '/usr/bin/env crontab ' . $filePath;

            $this->executeCommand(
                $command
            );
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    'Provided file path >>%s<< does not exist.',
                    $filePath
                )
            );
        }
    }

    /**
     * @param string $filePath
     * @return array
     * @throws RuntimeException
     */
    private function readFileAsArray(
        string $filePath
    ) : array {
        $contentAsString = $this->readFileAsString(
            $filePath
        );

        $contentAsArray = explode(
            PHP_EOL,
            $contentAsString
        );

        return $contentAsArray;
    }

    /**
     * @param string $filePath
     * @return string
     * @throws RuntimeException
     */
    private function readFileAsString(
        string $filePath
    ) : string {
        $contentOrFalse = file_get_contents($filePath);

        if ($contentOrFalse === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not read content of file path >>%s<<.',
                    $filePath
                )
            );
        }

        return $contentOrFalse;
    }

    /**
     * @throws RuntimeException
     */
    private function renderSectionTemplate()
    {
        $templateContent = $this->readFileAsString(
            $this->filePathTemplate
        );
        $renderedTemplateContent = str_replace(
            array_keys(
                $this->mapOfTemplateKeyToValue
            ),
            array_values(
                $this->mapOfTemplateKeyToValue
            ),
            $templateContent
        );
        $this->writeToFileFromString(
            $renderedTemplateContent,
            $this->filePathSectionRendered
        );
    }

    private function replaceSectionContent(
        array $listOfFullLine,
        array $listOfNewSectionContentLine,
        string $sectionUniqueIdentifier
    ) : array {
        $beginSectionLine           = '#begin of ' . $sectionUniqueIdentifier;
        $endSectionLine             = '#end of ' . $sectionUniqueIdentifier;
        $listOfUpdateLine           = [];
        $newSectionContentWasAdded  = false;
        $weAreInTheSection          = false;

        foreach ($listOfFullLine as $currentLine) {
            if ($currentLine === $beginSectionLine) {
                $weAreInTheSection = true;
                continue;
            }

            if ($currentLine === $endSectionLine) {
                $weAreInTheSection = false;
                continue;
            }

            if ($weAreInTheSection) {
                if ($newSectionContentWasAdded) {
                    continue;
                } else {
                    $listOfUpdateLine[] = $beginSectionLine;
                    foreach ($listOfNewSectionContentLine as $newLine) {
                        $listOfUpdateLine[] = $newLine;
                    }
                    $listOfUpdateLine[] = $endSectionLine;
                    $newSectionContentWasAdded = true;
                }
            } else {
                $listOfUpdateLine[] = $currentLine;
            }
        }

        return $listOfUpdateLine;
    }

    private function sliceSection(
        array $listOfFullLine,
        string $sectionUniqueIdentifier
    ) : array {
        $beginSectionLine       = '#begin of ' . $sectionUniqueIdentifier;
        $beginOfSectionFound    = false;
        $endSectionLine         = '#end of ' . $sectionUniqueIdentifier;
        $listOfSectionLine      = [];
        $weAreInTheSection      = false;

        foreach ($listOfFullLine as $currentLine) {
            if ($currentLine === $beginSectionLine) {
                $beginOfSectionFound = true;
                $weAreInTheSection = true;
                continue;
            }

            if ($currentLine === $endSectionLine) {
                $weAreInTheSection = false;
                continue;
            }

            $addToListOfSectionLine = (
                $beginOfSectionFound
                && $weAreInTheSection
            );
            if ($addToListOfSectionLine) {
                $listOfSectionLine[] = $currentLine;
            }
        }

        return $listOfSectionLine;
    }

    /**
     * @param string $command
     * @param array $listOfLine
     * @param int $returnCode
     * @throws RuntimeException
     */
    private function throwRuntimeExceptionIfReturnCodeIsGreaterZero(
        string $command,
        array $listOfLine,
        int $returnCode
    ) {
        if ($returnCode > 0) {
            throw new RuntimeException(
                sprintf(
                    'Return code of >>%d<< caught when executing command >>%s<<. Dumping returned content as json >>%s<<.',
                    $returnCode,
                    $command,
                    json_encode($listOfLine)
                )
            );
        }
    }

    /**
     * @param string $filePath
     * @param array $listOfLine
     * @throws RuntimeException
     */
    private function writeToFileFromArray(
        string $filePath,
        array $listOfLine
    ) {
        $this->writeToFileFromString(
            implode(
                PHP_EOL,
                $listOfLine
            ),
            $filePath
        );
    }

    /**
     * @param string $content
     * @param string $filePath
     * @throws RuntimeException
     */
    private function writeToFileFromString(
        string $content,
        string $filePath
    ) {
        $return = file_put_contents(
            $filePath,
            $content
        );

        if ($return === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not write content to file path >>%s<<.',
                    $filePath
                )
            );
        }
    }
}

$crontabManager = new CrontabManager(
    __DIR__ . '/data/full-crontab.dump',
    __DIR__ . '/data/section-crontab.dump',
    __DIR__ . '/data/section.rendered',
    __DIR__ . '/data/template.tpl',
    __DIR__ . '/data/updated-crontab.dump',
    [
        '{PATH_TO_THE_CRONTAB_LOG_FILE}'    => '/var/www/bazzline.net/my_example_bazzline_net_application/data/log/cronjob.log',
        '{PATH_TO_THE_INDEX_PHP}'           => '/var/www/bazzline.net/my_example_bazzline_net_application/public/index.php',
        '{PATH_TO_THE_PHP_BINARY}'          => '/usr/bin/php',
    ],
    'my_example_bazzline_net_application'
);

echo ':: Executing audit.' . PHP_EOL;
$crontabManager->audit();
echo PHP_EOL;
echo ':: Executing update.' . PHP_EOL;
$crontabManager->update();
