<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class DumpConfigurationContent implements ExecutableInterface
{
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

        $output = '<?php' . PHP_EOL;
        $output .= '/**' . PHP_EOL .
            ' * created at: ' . date('Y-m-d H:i:s', $this->timestamp) . PHP_EOL .
            ' * created by: net_bazzline/zf_cli_generator' . PHP_EOL .
            ' */' . PHP_EOL . PHP_EOL;
        $output .= 'return array(' . PHP_EOL;
        $output .= $this->dumpConfiguration($input, 'callApplication');
        $output .= ');';

        return $output;
    }

    /**
     * @param array $configuration
     * @param string $closureName
     * @param string $indention
     * @param int $level
     * @return string
     * @todo make closureName configurable
     */
    private function dumpConfiguration(array $configuration, $closureName, $indention = '    ', $level = 1)
    {
        $content        = '';
        $localIndention = str_repeat($indention, $level);
        end($configuration);
        $lastIndex      = key($configuration);

        foreach ($configuration as $index => $values) {
            if (empty($values)) {
                $content .= $localIndention . '\'' . $index . '\' => $' . $closureName;
            } else {
                $content .= $localIndention . '\'' . $index . '\' => array(' . PHP_EOL;
                $content .= $this->dumpConfiguration($values, $closureName, $indention, $level + 1);
                $content .= $localIndention . ')';
            }
            if ($index !== $lastIndex) {
                $content .= ',';
            }
            $content .= PHP_EOL;
        }

        return $content;
    }
}