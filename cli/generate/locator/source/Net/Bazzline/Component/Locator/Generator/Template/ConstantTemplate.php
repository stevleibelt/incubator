<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class ConstantTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class ConstantTemplate extends AbstractTemplate
{
    /**
     * @param PhpDocumentationTemplate $phpDocumentation
     */
    public function setDocumentation(PhpDocumentationTemplate $phpDocumentation)
    {
        $this->addProperty('documentation', $phpDocumentation, false);
    }

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
     * @param PhpDocumentationTemplate $phpDocumentation
     */

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fillOut()
    {
        $documentation = $this->getProperty('documentation');
        $name = $this->getProperty('name');
        $value = $this->getProperty('value');

        $block = $this->getBlock();

        if ($documentation instanceof PhpDocumentationTemplate) {
            $block->add(explode(PHP_EOL, $documentation->andConvertToString()));
        }
        $block->add('const ' . $name . ' = ' . $value . ';');
        $this->addContent($block);
    }
}