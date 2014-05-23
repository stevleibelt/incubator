#!/bin/php
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-23 
 */

namespace Net\Bazzline\Component\Locator\Generator\Example;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

/**
 * Class SentenceExample
 * @package Net\Bazzline\Component\Locator\Generator\Example
 */
class SentenceExample extends AbstractExample
{
    /**
     * @return mixed
     */
    function demonstrate()
    {
        $lineFactory = $this->getLineGeneratorFactory();
        $line = $lineFactory->create();
        $line->setSeparator(', ');

        $line->add('first three words');
        $line->add('followed by more words');
        echo $line->generate() . PHP_EOL;
    }
}

$example = new SentenceExample();
$example->demonstrate();