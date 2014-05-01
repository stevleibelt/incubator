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
    /** @var bool */
    private $completePhpDocumentationAutomatically = false;

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
        if ($this->completePhpDocumentationAutomatically === true) {
            /** @var PhpDocumentationTemplate $documentation */
            $documentation = $this->getProperty('documentation');
            $documentation->addParameter($name, array($typeHint));
        }
    }

    /**
     * @return null|array
     */
    public function getBody()
    {
        return $this->getProperty('body', null);
    }

    /**
     * @return null|PhpDocumentationTemplate
     */
    public function getDocumentation()
    {
        return $this->getProperty('documentation');
    }

    public function setIsAbstract()
    {
        $this->addProperty('abstract', true, false);
    }

    /**
     * @param array $body
     */
    public function setBody(array $body)
    {
        $this->addProperty('body', $body, false);
        $this->addProperty('has_body', true, false);
    }

    /**
     * @param PhpDocumentationTemplate $phpDocumentation
     * @param bool $completeAutomatically
     */
    public function setDocumentation(PhpDocumentationTemplate $phpDocumentation, $completeAutomatically = true)
    {
        $this->addProperty('documentation', $phpDocumentation, false);
        $this->completePhpDocumentationAutomatically = $completeAutomatically;
    }

    public function setHasNoBody()
    {
        $this->addProperty('has_body', false, false);
    }

    public function setIsFinal()
    {
        $this->addProperty('final', true, false);
    }

    public function setIsPrivate()
    {
        $this->addProperty('visibility', 'private', false);
    }

    public function setIsProtected()
    {
        $this->addProperty('visibility', 'protected', false);
    }

    public function setIsPublic()
    {
        $this->addProperty('visibility', 'public', false);
    }

    public function setIsStatic()
    {
        $this->addProperty('static', true, false);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addProperty('name', (string) $name, false);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fillOut()
    {
        $this->fillOutPhpDocumentation();
        $this->fillOutSignature();
        $this->fillOutBody();
    }

    private function fillOutBody()
    {
        $hasBody    = $this->getProperty('has_body', true);
        $isAbstract = $this->getProperty('abstract', false);

        if (!$isAbstract
            && $hasBody) {
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

    private function fillOutPhpDocumentation()
    {
        $documentation = $this->getProperty('documentation');

        if ($documentation instanceof PhpDocumentationTemplate) {
            $documentation->fillOut();
            $this->addTemplateAsContent($documentation);
        }
    }

    private function fillOutSignature()
    {
        $hasBody        = $this->getProperty('has_body', true);
        $isAbstract     = $this->getProperty('abstract', false);
        $isFinal        = $this->getProperty('final', false);
        $isStatic       = $this->getProperty('static', false);
        $name           = $this->getProperty('name');
        $parameters     = $this->getProperty('parameters', array());
        $visibility     = $this->getProperty('visibility');

        $line = $this->getLine();

        if ($isAbstract) {
            $line->add('abstract');
        } else if ($isFinal) {
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
            if ((strlen($parameter['type_hint']) > 0)
                && (!in_array($parameter['type_hint'], $this->getNotPrintableTypeHints()))) {
                $parameterLine->add($parameter['type_hint']);
            }
            $parameterLine->add(($parameter['is_reference'] ? '&' : '') . '$' . $parameter['name']);
            if (strlen((string) $parameter['default_value']) > 0) {
                $parameterLine->add('= ' . (string) $parameter['default_value']);
            }
        }
        $line->add('function ' . $name . '(' . $parameterLine->andConvertToString() . ')' . ((($isAbstract) || (!$hasBody)) ? ';' : ''));
        $this->addContent($line);
    }
}