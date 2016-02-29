#!/usr/bin/env php
<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-02-29
 */
use Net\Bazzline\Component\CLI\StandardStreams\Input;
use Net\Bazzline\Component\CLI\StandardStreams\Output;

require_once __DIR__ . '/../source/ReaderInterface.php';
require_once __DIR__ . '/../source/WriterInterface.php';
require_once __DIR__ . '/../source/AbstractWriter.php';
require_once __DIR__ . '/../source/Input.php';
require_once __DIR__ . '/../source/Output.php';

$input  = new Input();
$output = new Output();

$output->writeLine('simple write what you want and hit enter');

$content = $input->read();

$output->writeLine('read string with length of ' . strlen($content) . ' characters');
$output->write('content was: ');
$output->writeLine('"' . $content . '"');
