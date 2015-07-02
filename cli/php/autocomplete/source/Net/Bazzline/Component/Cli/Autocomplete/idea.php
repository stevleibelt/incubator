#!/usr/bin/env php
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-30
 * @see:
 *  https://github.com/stevleibelt/examples/blob/master/php/cli/readline.php
 *  https://github.com/yiisoft/yii2/issues/7974
 *  https://github.com/ErikDubbelboer/php-repl/blob/master/repl.php
 */

if (!function_exists('readline')) {
    echo 'readline not installed' . PHP_EOL;
    exit(1);
}

function completion($input, $index, $length)
{
    $completion = array(
        'clear' => array(),
        'exit' => array(),
        'help' => array(),
        'read' => array(
            'all',
            'many',
            'one'
        ),
        'write' => array(
            'all',
            'many',
            'one'
        )
    );


    if (($index === 0) && empty($input)) {
        $completion = array_keys($completion);
    } else {
        if ($index === 0) {
            $values     = array_keys($completion);
            $completion = array();

            foreach ($values as $value) {
                if (substr($value, 0, $length) === $input) {
                    $completion[] = $value;
                }
            }
        } else {
            $buffer         = preg_replace('/\s+/', ' ', trim(readline_info('line_buffer')));
            $bufferInTokens = explode(' ', $buffer);
            $level          = count($bufferInTokens);

            if ($level === 1) {
                $parent = $bufferInTokens[0];

                if (isset($completion[$parent])) {
                    $completion = $completion[$parent];
                } else {
                    $completion = false;
                }
            } else if ($level === 2) {
                $parent                     = $bufferInTokens[0];
                $inputLengthIsGreaterZero   = (strlen($input) > 0);

                if ($inputLengthIsGreaterZero && isset($completion[$parent])) {
                    $position   = strlen($input);
                    $values     = $completion[$parent];
                    $completion = array();

                    foreach ($values as $value) {
                        if (substr($value, 0, $position) === $input) {
                            $completion[] = $value;
                        }
                    }

                    if (empty($completion)) {
                        $completion = false;
                    }
                } else {
                    $completion = false;
                }
            } else {
                $completion = false;
            }
        }
    }

    return $completion;
}

readline_completion_function('completion');

try {
    $path = ($argc > 1) ? $argv[1] : __DIR__ . '/file/example.csv';

    if (!file_exists($path)) {
        throw new Exception('invalid file path provided: "' . $path . '"');
    }

    require_once __DIR__ . '/../vendor/autoload.php';

    $factory    = new \Net\Bazzline\Component\Csv\Reader\ReaderFactory();
    $reader     = $factory->create();
    $factory    = new \Net\Bazzline\Component\Csv\Writer\WriterFactory();
    $writer     = $factory->create();

    $reader->setPath($path);
    $writer->setPath($path);

    while (true) {
        $line   = readline('cli: ');
        $tokens = explode(' ', $line);

        if (!empty($tokens)) {
            //readline_add_history($line);
            switch ($tokens[0]) {
                case 'read':
                    if (isset($tokens[1])) {
                        switch ($tokens[1]) {
                            case 'all':
                                echo var_export($reader->readAll(), true) . PHP_EOL;
                                break;
                            case 'many':
                                $showUsage = (!isset($tokens[2]) || ((int) $tokens[2]) === 0);
                                if ($showUsage) {
                                    echo 'usage: ' . PHP_EOL .
                                        '    read many <length> [<start>]' . PHP_EOL;
                                } else {
                                    $length = $tokens[2];
                                    $start  = (isset($tokens[3]) ? $tokens[3] : null);
                                    echo var_export($reader->readMany($length, $start), true) . PHP_EOL;
                                }
                                break;
                            case 'one':
                                $start = (isset($tokens[2])) ? (int) $tokens[2] : null;
                                echo var_export($reader->readOne($start), true) . PHP_EOL;
                                break;
                        }
                    }
                    break;
                case 'write':
                    if (isset($tokens[1])) {
                        switch ($tokens[1]) {
                            //@todo add support for headlines | truncate | copy ...
                            case 'all':
                            case 'many':
                                $lines = $tokens;
                                array_shift($lines);
                                array_shift($lines);

                                if ($tokens[1] === 'all') {
                                    $numberOfLines = $writer->writeAll($lines);
                                } else {
                                    $numberOfLines = $writer->writeMany($lines);
                                }

                                if ($numberOfLines === false) {
                                    echo 'no lines where written' . PHP_EOL;
                                } else {
                                    echo count($lines) . ' lines written' . PHP_EOL;
                                }
                                break;
                            case 'one':
                                $numberOfLines = $writer->writeOne($tokens[2]);

                                if ($numberOfLines === false) {
                                    echo 'no lines where written' . PHP_EOL;
                                } else {
                                    echo '1 line written' . PHP_EOL;
                                }
                                break;
                        }
                    }
                    break;
                case 'clear':
                    readline_clear_history();
                    break;
                case 'exit':
                    exit(0);
                    break;
                case 'help':
                    echo 'usage: ' . PHP_EOL .
                        '    ' . basename(__FILE__) . ' [path to csv file]' . PHP_EOL;
                    break;
                default:
                    break;
            }
        }
        readline_add_history($line);
        usleep(500000);
    }
} catch (Exception $exception) {
    echo 'usage: ' . basename(__FILE__) . ' [<path/to/csv>]' . PHP_EOL;
    echo '----------------' . PHP_EOL;
    echo $exception->getMessage() . PHP_EOL;
    return 1;
}