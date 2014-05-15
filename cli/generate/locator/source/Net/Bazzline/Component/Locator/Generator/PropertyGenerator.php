<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

namespace Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class PropertyGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class PropertyGenerator extends AbstractDocumentedGenerator
{
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addProperty('name', (string) $name, false);
        if ($this->completeDocumentationAutomatically === true) {
            /** @var DocumentationGenerator $documentation */
            $documentation = $this->getProperty('documentation');
            //@todo
            //$documentation->setVariable($name);
        }
    }

    public function markAsPrivate()
    {
        $this->addProperty('visibility', 'private', false);
    }

    public function markAsProtected()
    {
        $this->addProperty('visibility', 'protected', false);
    }

    public function markAsPublic()
    {
        $this->addProperty('visibility', 'public', false);
    }

    public function markAsStatic()
    {
        $this->addProperty('static', true, false);
    }

    /**
     * @param string $typeHint
     */
    public function addTypeHint($typeHint)
    {
        $this->addProperty('type_hint', (string) $typeHint);
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
        $documentation = $this->getProperty('documentation');
        $isStatic = $this->getProperty('static', false);
        $name = $this->getProperty('name');
        $value = $this->getProperty('value');
        $visibility = $this->getProperty('visibility');

        if (is_null($name)) {
            throw new RuntimeException('name is mandatory');
        }

        $block = $this->getBlockGenerator();
        $line = $this->getLineGenerator();

        if ($documentation instanceof DocumentationGenerator) {
            $block->add(explode(PHP_EOL, $documentation->generate()));
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

        return $this->generateStringFromContent();
    }
}