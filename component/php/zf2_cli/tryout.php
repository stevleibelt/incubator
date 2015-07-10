<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-09
 */

require_once __DIR__ . '/vendor/autoload.php';

$pathToApplication = ($argc > 1) ? $argv[1] : __DIR__ . '/../../../../../bazzline/zf_demo_environment/public/index.php';

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
NetBazzlineZfLocatorGenerator
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php net_bazzline locator generate [<locator_name>] [--verbose]    run generation of locator depending on your configuration
  index.php net_bazzline locator list                                     list available locator with configuration path

Reason for failure: Invalid arguments or no arguments provided
EOF;
}

class FetchIndexFileContentCommand extends  \Net\Bazzline\Component\Command\Command
{
    /**
     * @return array
     */
    public function fetch($path)
    {
        $command = '/usr/bin/env php ' . $path;

        return $this->execute($command, false); //we know zf application will use exit greater 0
    }
}

function fetchTextToParse($path)
{
    $command = new FetchIndexFileContentCommand();

    return $command->fetch($path);
}

function addToArray(array $array, array $path)
{
    $section = array_shift($path);

    if (!isset($array[$section])) {
        $array[$section]= array();
    }

    if (!empty($path)) {
        $array[$section] = addToArray($array[$section], $path);
    }

    return $array;
}

function startsWith($haystack, $needle)
{
    return (strncmp($haystack, $needle, strlen($needle)) === 0);
}

//steps
//  fetch lines
//  filter lines
//  sanitize lines
//  parse lines

//  fetch lines
//exec('/usr/bin/env php public/index.php', $lines); //use command component
/*
$text   = getTextToParse();
$lines  = explode(PHP_EOL, $text);
*/
$lines   = fetchTextToParse($pathToApplication);

//  filter lines
//remove first two and last line
array_shift($lines);
array_shift($lines);
array_pop($lines);

$moduleHeadlineDetected = false;

$filtered = array();

foreach ($lines as $line) {
    //remove color codes
    $line = preg_replace('/\033\[[0-9;]*m/', '', $line);
    $isValid = true;
    if (startsWith($line, '-')) {
        $isValid = false;
        $moduleHeadlineDetected = ($moduleHeadlineDetected === true) ? false: true;
    } else if (strlen(trim($line)) === 0) {
        $isValid = false;
    }

    if ($moduleHeadlineDetected === true) {
        $isValid = false;
    }

    if ($isValid) {
        $filtered[] = $line;
    }
}

//  sanitize lines

$lines = array_map(function ($line) {
    $line = str_replace(array('public/index.php', 'index.php'), '', $line);
    $line = trim($line);

    return $line;
}, $filtered);

//  parse lines
//  @see:
//      http://framework.zend.com/manual/current/en/modules/zend.console.routes.html
//      http://framework.zend.com/manual/current/en/modules/zend.console.routes.html#console-routes-cheat-sheet

//we won't take care of "--foo", "-f", <foo>, [<foo>] nor [foo]

$configuration = array();

foreach ($lines as $line) {
    //remove description
    $breadcrumb                     = array();
    $positionOfMultipleWhitespaces  = strpos($line, '  ');
    if (is_numeric($positionOfMultipleWhitespaces)) {
        $line = substr($line, 0, $positionOfMultipleWhitespaces);
    }
    //replace multiple whitespaces with one
    //$line = preg_replace('/\s+/', ' ',$line);
    $tokens                         = explode(' ', $line);

    foreach ($tokens as $token) {
        $isValid = true;
        foreach (array('-', '<', '[') as $needle) {
            if (startsWith($token, $needle)) {
                $isValid = false;
                break 2;
            }
        }

        if ($isValid) {
            $breadcrumb[] = $token;
        }
    }
    $configuration = addToArray($configuration, $breadcrumb);

    //echo '----------------' . PHP_EOL;
    echo 'line: ' . $line . PHP_EOL;
    //echo 'tokens: ' . var_export($tokens, true) . PHP_EOL;
    //echo 'breadcrumb: ' . var_export($breadcrumb, true) . PHP_EOL;
}
echo PHP_EOL;
echo 'configuration: ' . var_export($configuration, true) . PHP_EOL;
