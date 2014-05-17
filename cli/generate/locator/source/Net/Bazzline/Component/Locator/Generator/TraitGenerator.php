<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class TraitGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class TraitGenerator extends AbstractDocumentedGenerator
{
    /**
     * @param ConstantGenerator $constant
     */
    public function addConstant(ConstantGenerator $constant)
    {
        $this->addGeneratorProperty('constants', $constant);
    }

    /**
     * @param PropertyGenerator $property
     */
    public function addProperty(PropertyGenerator $property)
    {
        $this->addGeneratorProperty('properties', $property);
    }

    /**
     * @param MethodGenerator $method
     */
    public function addMethod(MethodGenerator $method)
    {
        $this->addGeneratorProperty('methods', $method);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addGeneratorProperty('name', (string) $name, false);
        if ($this->completeDocumentationAutomatically === true) {
            /** @var DocumentationGenerator $documentation */
            $documentation = $this->getGeneratorProperty('documentation');
            $documentation->setClass($name);
        }
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->getGeneratorProperty('name');
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        if ($this->canBeGenerated()) {
            $this->generateDocumentation();
            $this->generateSignature();
            $this->generateBody();
        }

        return $this->generateStringFromContent();
    }

    private function generateBody()
    {
        $this->addContent('{');
        /** @var null|ConstantGenerator[] $constants */
        $constants = $this->getGeneratorProperty('constants');
        /** @var null|MethodGenerator[] $methods */
        $methods = $this->getGeneratorProperty('methods');
        /** @var null|PropertyGenerator[] $properties */
        $properties = $this->getGeneratorProperty('properties');

        if (is_array($constants)) {
            foreach($constants as $constant) {
                $constant->generate();
                $this->addGeneratorAsContent($constant, true);
                $this->addContent('');
            }
        }
        if (is_array($properties)) {
            foreach($properties as $property) {
                $property->generate();
                $this->addGeneratorAsContent($property, true);
                $this->addContent('');
            }
        }
        if (is_array($methods)) {
            foreach($methods as $method) {
                $method->generate();
                $this->addGeneratorAsContent($method, true);
                $this->addContent('');
            }
        }

        $this->addContent('}');
    }

    private function generateDocumentation()
    {
        $documentation = $this->getGeneratorProperty('documentation');

        if ($documentation instanceof DocumentationGenerator) {
            $documentation->generate();
            $this->addGeneratorAsContent($documentation);
        }
    }

    /**
     * @throws \Net\Bazzline\Component\Locator\Generator\RuntimeException
     */
    private function generateSignature()
    {
        $name = $this->getGeneratorProperty('name');

        if (is_null($name)) {
            throw new RuntimeException('name is mandatory');
        }

        $line = $this->getLineGenerator('trait ' . $name);
        $this->addContent($line);
    }
}
