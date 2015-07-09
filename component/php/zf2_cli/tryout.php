<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-09
 */

function getTextToParse()
{
    return <<<EOF
Zf Index - Version 1.0.0
Net\Bazzline Zf Locator Generator - Version 1.0.0

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Application
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php console index [--verbose]    run index

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
ZfLocatorGenerator
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php net_bazzline locator generate [<locator_name>] [--verbose]    run generation of locator depending on your configuration
  index.php net_bazzline locator list                                     list available locator with configuration path

Reason for failure: Invalid arguments or no arguments provided
EOF;
}

function startsWith($haystack, $needle)
{
    return (strncmp($haystack, $needle, strlen($needle)) === 0);
}

$text   = getTextToParse();
$lines  = explode(PHP_EOL, $text);
end($lines);
$lastIndex = key($lines);
rewind($lines);

$indexToRemove = array(
    0,
    1,
    $lastIndex
);

foreach ($lines as $index => $line) {
    if (startsWith($line, '-')) {
        $indexToRemove[] = $index;
    }
}

$lines  = array_filter($lines, function($line){
    $doesNotStartWithZend   = !startsWith($line, 'Zend');
    $lengthIsGreaterZero    = (strlen($line) > 0);
    $doesNotStartWithMinus  = !startsWith($line, '-');

    return ($lengthIsGreaterZero
        && $doesNotStartWithZend
        && $doesNotStartWithMinus);
});
$lines  = array_map(function($line) {
    return trim($line);
}, $lines);

echo var_export($lines, true) . PHP_EOL;
