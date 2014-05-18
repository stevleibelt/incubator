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
 * @todo implement usage of type hint
 * @todo implement usage of documentation
 */
class PropertyGenerator extends AbstractDocumentedGenerator
{
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addGeneratorProperty('name', (string) $name, false);
        if ($this->completeDocumentationAutomatically === true) {
            /** @var DocumentationGenerator $documentation */
            $documentation = $this->getGeneratorProperty('documentation');
            //@todo
            //$documentation->setVariable($name);
        }
    }

    public function markAsPrivate()
    {
        $this->addGeneratorProperty('visibility', 'private', false);
    }

    public function markAsProtected()
    {
        $this->addGeneratorProperty('visibility', 'protected', false);
    }

    public function markAsPublic()
    {
        $this->addGeneratorProperty('visibility', 'public', false);
    }

    public function markAsStatic()
    {
        $this->addGeneratorProperty('static', true, false);
    }

    /**
     * @param string $typeHint
     */
    public function addTypeHint($typeHint)
    {
        $this->addGeneratorProperty('type_hint', (string) $typeHint);
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->addGeneratorProperty('value', (string) $value, false);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        $documentation = $this->getGeneratorProperty('documentation');
        $isStatic = $this->getGeneratorProperty('static', false);
        $name = $this->getGeneratorProperty('name');
        $value = $this->getGeneratorProperty('value');
        $visibility = $this->getGeneratorProperty('visibility');

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