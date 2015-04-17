<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-16
 */

require_once __DIR__ . '/Arguments.php';

$arguments = new Arguments($argv);

if ($arguments->hasArguments()) {
    echo 'arguments provided:' . PHP_EOL;
    foreach ($arguments->getArguments() as $argument) {
        echo '    ' . $argument . PHP_EOL;
    }
} else {
    echo 'no values provided' . PHP_EOL;
}

if ($arguments->hasLists()) {
    echo 'lists provided:' . PHP_EOL;
    foreach ($arguments->getLists() as $name => $values) {
        echo '    ' . $name . PHP_EOL;
        foreach ($values as $value) {
            echo '        ' . $value . PHP_EOL;
        }
    }
} else {
    echo 'no values provided' . PHP_EOL;
}

if ($arguments->hasTriggers()) {
    echo 'triggers provided:' . PHP_EOL;
    foreach ($arguments->getTriggers() as $trigger) {
        echo '    ' . $trigger . PHP_EOL;
    }
} else {
    echo 'no triggers provided' . PHP_EOL;
}

if ($arguments->hasValues()) {
    echo 'values provided:' . PHP_EOL;
    foreach ($arguments->getValues() as $value) {
        echo '    ' . $value . PHP_EOL;
    }
} else {
    echo 'no values provided' . PHP_EOL;
}