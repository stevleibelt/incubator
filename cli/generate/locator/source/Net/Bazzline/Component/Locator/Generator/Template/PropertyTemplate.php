<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class PropertyTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class PropertyTemplate extends AbstractTemplate
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

    public function setPrivate()
    {
        $this->addProperty('visibility', 'private', false);
    }

    public function setProtected()
    {
        $this->addProperty('visibility', 'protected', false);
    }

    public function setPublic()
    {
        $this->addProperty('visibility', 'public', false);
    }

    public function setStatic()
    {
        $this->addProperty('static', true, false);
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
     */
    public function fillOut()
    {
        $documentation = $this->getProperty('documentation');
        $isFinal = $this->getProperty('final', false);
        $isStatic = $this->getProperty('static', false);
        $name = $this->getProperty('name');
        $value = $this->getProperty('value');
        $visibility = $this->getProperty('visibility');

        $block = $this->getBlock();
        $line = $this->getLine();

        if ($documentation instanceof PhpDocumentationTemplate) {
            $block->add(explode(PHP_EOL, $documentation->andConvertToString()));
        }
        if ($isFinal) {
            $line->add('final');
        }

        if (!is_null($visibility)) {
            $line->add($visibility);
        }

        if ($isStatic) {
            $line->add('static');
        }
        if (!is_null($value)) {
            $line->add('$' . $name . ' = ' . $value . ';');
        } else {
            $line->add('$' . $name . ';');
        }
        $block->add($line);
        $this->addContent($block);
    }
}