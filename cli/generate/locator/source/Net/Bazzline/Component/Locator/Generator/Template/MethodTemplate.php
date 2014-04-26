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
     * @param string $name
     * @param string $defaultValue
     * @param string $typeHint
     * @param bool $isReference
     */
    public function addParameter($name, $defaultValue = '', $typeHint = '', $isReference = false)
    {
        $parameter = array(
            'default_value' => $defaultValue,
            'name'          => $name,
            'is_reference'  => $isReference,
            'type_hint'     => $typeHint
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
            $this->addContent($this->getLine('{'));
            $this->addContent(
                $this->getBlock(
                    $this->getProperty('body', array('//@todo implement'))
                ),
                true
            );
            $this->addContent($this->getLine('}'));
        }
    }

    /**
     * @return string
     */
    private function fillOutSignature()
    {
        $isAbstract = $this->getProperty('abstract', false);
        $isFinal = $this->getProperty('final', false);
        $isStatic = $this->getProperty('static', false);
        $name = $this->getProperty('name');
        $parameters = $this->getProperty('parameters', array());
        $visibility = $this->getProperty('visibility');

        $line = $this->getLine();

        if ($isAbstract) {
            $line->add('abstract');
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

        $parameterLine = $this->getLine();
        foreach ($parameters as $parameter) {
            if (strlen($parameter['type_hint']) > 0) {
                $parameterLine->add($parameter['type_hint']);
            }
            $parameterLine->add(($parameter['is_reference'] ? '&' : '') . '$' . $parameter['name']);
            if (strlen((string) $parameter['default_value']) > 0) {
                $parameterLine->add('= ' . (string) $parameter['default_value']);
            }
        }
        $line->add('function ' . $name . '(' . $parameterLine->andConvertToString() . ')' . (($isAbstract) ? ';' : ''));
        $this->addContent($line);
    }
}