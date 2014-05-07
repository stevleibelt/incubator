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
    public function addTraitConstant(ConstantGenerator $constant)
    {
        $this->addProperty('constants', $constant);
    }

    /**
     * @param PropertyGenerator $property
     */
    public function addTraitProperty(PropertyGenerator $property)
    {
        $this->addProperty('properties', $property);
    }

    /**
     * @param MethodGenerator $method
     */
    public function addMethod(MethodGenerator $method)
    {
        $this->addProperty('methods', $method);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addProperty('name', (string) $name, false);
        if ($this->completeDocumentationAutomatically === true) {
            /** @var DocumentationGenerator $documentation */
            $documentation = $this->getProperty('documentation');
            $documentation->setClass($name);
        }
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->getProperty('name');
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function generate()
    {
        $this->generateDocumentation();
        $this->generateSignature();
        $this->generateBody();
    }

    private function generateBody()
    {
        $this->addContent('{');
        /** @var null|ConstantGenerator[] $constants */
        $constants = $this->getProperty('constants');
        /** @var null|MethodGenerator[] $methods */
        $methods = $this->getProperty('methods');
        /** @var null|PropertyGenerator[] $properties */
        $properties = $this->getProperty('properties');

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
        $documentation = $this->getProperty('documentation');

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
        $name = $this->getProperty('name');

        if (is_null($name)) {
            throw new RuntimeException('name is mandatory');
        }

        $line = $this->getLineGenerator('trait ' . $name);
        $this->addContent($line);
    }
}
