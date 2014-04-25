<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

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
    public function render()
    {
        $this->renderedContent = array(
            $this->renderSignature(),
            $this->renderBody(),
        );
    }

    /**
     * @return string|array
     */
    private function renderBody()
    {
        $isAbstract = $this->getProperty('abstract', false);
        $array = array();

        if ($isAbstract) {
            $array[] = ';';
        } else {
            $array[] = '{';
            $array[] = $this->getProperty('body', array('//@todo implement'));
            $array[] = '}';
        }

        return $array;
    }

    /**
     * @return string
     */
    private function renderSignature()
    {
        $isAbstract = $this->getProperty('abstract', false);
        $isFinal = $this->getProperty('final', false);
        $isPrivate = $this->getProperty('private', false);
        $isProtected = $this->getProperty('protected', false);
        $isPublic = $this->getProperty('public', false);
        $isStatic = $this->getProperty('static', false);
        $name = $this->getProperty('name');
        $parameters = $this->getProperty('parameters', array());

        $string = '';

        if ($isAbstract) {
            $string .= 'abstract ';
        }

        if ($isFinal) {
            $string .= 'final ';
        }

        if ($isPrivate) {
            $string .= 'private ';
        } else if ($isProtected) {
            $string .= 'protected ';
        } else if ($isPublic) {
            $string .= 'public ';
        }

        if ($isStatic) {
            $string .= 'static ';
        }

        $string .= 'function ' . $name . '(';
        foreach ($parameters as $parameter) {
            if (strlen($parameter['type']) > 0) {
                $string .= $parameter['type'] . ' ';
            }
            $string .= ($parameter['is_reference'] ? '&' : '') . '$' . $parameter['name'];
            if (strlen((string) $parameter['default']) > 0) {
                $string .= ' = ' . (string) $parameter['default'];
            }
        }
        $string .= ')';

        return $string;
    }
}