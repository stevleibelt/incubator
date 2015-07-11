<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class DumpCliContent implements ExecutableInterface
{
    const INPUT_KEY_PREFIX_CLI              = 'prefix_cli';
    const INPUT_KEY_PATH_TO_APPLICATION     = 'path_to_application';
    const INPUT_KEY_PATH_TO_CONFIGURATION   = 'path_to_configuration';

    /** @var int */
    private $timestamp;

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @param mixed $input
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($input = null)
    {
        $this->validateInput($input);

        $date                   = date('Y-m-d H:i:s');
        $prefix                 = $input[self::INPUT_KEY_PREFIX_CLI];
        $pathToApplication      = $input[self::INPUT_KEY_PATH_TO_APPLICATION];
        $pathToConfiguration    = $input[self::INPUT_KEY_PATH_TO_CONFIGURATION];

        $output = <<<EOC
#!/usr/bin/env php
<?php
/**
 * @author Net\Bazzline Zf Cli Generator
 * @since $date
 */

use Net\Bazzline\Component\Cli\Readline\ManagerFactory;
use Net\Bazzline\Component\Csv\Reader\ReaderFactory;
use Net\Bazzline\Component\Csv\Writer\WriterFactory;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    \$factory           = new ManagerFactory();
    \$manager           = \$factory->create();
    \$configuration     = file_get_contents(\'$pathToConfiguration\');
    \$callApplication   = function (\$line) {
        \$command    = '/usr/bin/env php $pathToApplication ' . \$line;
        \$return     = 0:

        passthru(\$command, \$return);
        exit(\$return);
    };

    \$manager->setConfiguration(\$configuration);
    \$manager->setPrompt($prefix);
    \$manager->run();
} catch (Exception \$exception) {
    echo 'usage: ' . basename(__FILE__) . ' [<path/to/csv>]' . PHP_EOL;
    echo '----------------' . PHP_EOL;
    echo \$exception->getMessage() . PHP_EOL;
    return 1;
}
EOC;


        return $output;
    }

    /**
     * @param mixed $input
     * @throws ExecutableException
     */
    private function validateInput($input)
    {
        if (!is_array($input)) {
            throw new ExecutableException(
                'input must be an array'
            );
        }

        if (empty($input)) {
            throw new ExecutableException(
                'empty input provided'
            );
        }

        $keys = array(
            self::INPUT_KEY_PATH_TO_APPLICATION,
            self::INPUT_KEY_PATH_TO_CONFIGURATION,
            self::INPUT_KEY_PREFIX_CLI
        );

        foreach ($keys as $key) {
            if (!isset($input[$key])) {
                throw new ExecutableException(
                    'input must contain mandatory key "' . $key . '"'
                );
            }
        }
    }
}