<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class TraitTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class TraitTemplate extends AbstractTemplate
{
    /**
     * @param ConstantTemplate $constant
     */
    public function addTraitConstant(ConstantTemplate $constant)
    {
        $this->addProperty('constants', $constant);
    }

    /**
     * @param PropertyTemplate $property
     */
    public function addTraitProperty(PropertyTemplate $property)
    {
        $this->addProperty('properties', $property);
    }

    /**
     * @param MethodTemplate $method
     */
    public function addMethod(MethodTemplate $method)
    {
        $this->addProperty('methods', $method);
    }

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
        $this->addContent('{');
        /** @var null|ConstantTemplate[] $constants */
        $constants = $this->getProperty('constants');
        /** @var null|MethodTemplate[] $methods */
        $methods = $this->getProperty('methods');
        /** @var null|PropertyTemplate[] $properties */
        $properties = $this->getProperty('properties');

        if (is_array($constants)) {
            foreach($constants as $constant) {
                $constant->fillOut();
                $this->addTemplateAsContent($constant, true);
                $this->addContent('');
            }
        }
        if (is_array($properties)) {
            foreach($properties as $property) {
                $property->fillOut();
                $this->addTemplateAsContent($property, true);
                $this->addContent('');
            }
        }
        if (is_array($methods)) {
            foreach($methods as $method) {
                $method->fillOut();
                $this->addTemplateAsContent($method, true);
                $this->addContent('');
            }
        }

        $this->addContent('}');
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
        $name = $this->getProperty('name');
        $line = $this->getLine('trait ' . $name);
        $this->addContent($line);
    }
}
