<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class MethodTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class MethodTemplate extends AbstractTemplate
{
    public function setAbstract()
    {
        $this->addProperty('abstract', true, false);
    }

    /**
     * @param array $body
     */
    public function setBody(array $body)
    {
        $this->addProperty('body', $body, false);
    }

    public function setFinal()
    {
        $this->addProperty('final', true, false);
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
        $this->addProperty('private', true, false);
    }

    public function setProtected()
    {
        $this->addProperty('protected', true, false);
    }

    public function setPublic()
    {
        $this->addProperty('public', true, false);
    }

    public function setStatic()
    {
        $this->addProperty('static', true, false);
    }

    /**
     * @param string $name
     * @param string $default
     * @param string $type
     * @param bool $isReference
     */
    public function addParameter($name, $default = '', $type = '', $isReference = false)
    {
        $parameter = array(
            'default'       => $default,
            'name'          => $name,
            'is_reference'  => $isReference,
            'type'          => $type
        );

        $this->addProperty('parameters', $parameter);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fillOut()
    {
        $this->fillOutSignature();
        $this->fillOutBody();
    }

    private function fillOutBody()
    {
        $isAbstract = $this->getProperty('abstract', false);

        if (!$isAbstract) {
            $block = $this->getBlock();
            $block->add('{');
            $block->add($this->getProperty('body', array('//@todo implement')));
            $block->add('}');
            $this->addContent($block);
        }
    }

    /**
     * @return string
     */
    private function fillOutSignature()
    {
        $isAbstract = $this->getProperty('abstract', false);
        $isFinal = $this->getProperty('final', false);
        $isPrivate = $this->getProperty('private', false);
        $isProtected = $this->getProperty('protected', false);
        $isPublic = $this->getProperty('public', false);
        $isStatic = $this->getProperty('static', false);
        $name = $this->getProperty('name');
        $parameters = $this->getProperty('parameters', array());

        $line = $this->getLine();

        if ($isAbstract) {
            $line->add('abstract');
        }

        if ($isFinal) {
            $line->add('final');
        }

        if ($isPrivate) {
            $line->add('private');
        } else if ($isProtected) {
            $line->add('protected');
        } else if ($isPublic) {
            $line->add('public');
        }

        if ($isStatic) {
            $line->add('static');
        }

        $parameterLine = $this->getLine();
        foreach ($parameters as $parameter) {
            if (strlen($parameter['type']) > 0) {
                $parameterLine->add($parameter['type']);
            }
            $parameterLine->add(($parameter['is_reference'] ? '&' : '') . '$' . $parameter['name']);
            if (strlen((string) $parameter['default']) > 0) {
                $parameterLine->add('= ' . (string) $parameter['default']);
            }
        }
        $line->add('function ' . $name . '(' . $parameterLine->andConvertToString() . ')' . (($isAbstract) ? ';' : ''));
        $this->addContent($line);
    }
}