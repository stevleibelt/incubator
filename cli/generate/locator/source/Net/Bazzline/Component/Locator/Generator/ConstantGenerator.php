<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class ConstantGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class ConstantGenerator extends AbstractGenerator
{
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addProperty('name', (string) $name, false);
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->addProperty('value', (string) $value, false);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        if ($this->canBeGenerated()) {
            $name = $this->getProperty('name');
            $value = $this->getProperty('value');

            if (is_null($name)
                || is_null($value)) {
                throw new RuntimeException('name and value are mandatory');
            }

            $block = $this->getBlockGenerator();

            $block->add('const ' . $name . ' = ' . $value . ';');
            $this->addContent($block);
        }

        return $this->generateStringFromContent();
    }
}