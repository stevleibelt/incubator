<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-14 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class FileGenerator
 * @package Net\Bazzline\Component\Locator\Generator
 */
class FileGenerator extends AbstractDocumentedGenerator
{
    /** @var boolean */
    private $addEmptyLine;

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
     * @param ClassGenerator $class
     */
    public function addClass(ClassGenerator $class)
    {
        $this->addGeneratorProperty('classes', $class);
    }

    /**
     * @param MethodGenerator $method
     */
    public function addMethod(MethodGenerator $method)
    {
        $this->addGeneratorProperty('methods', $method);
    }

    /**
     * @param TraitGenerator $trait
     */
    public function addTrait(TraitGenerator $trait)
    {
        $this->addGeneratorProperty('traits', $trait->getName());
    }

    public function markAsExecutable()
    {
        $this->addGeneratorProperty('is_executable', true, false);
    }

    /**
     * @param int|string|array $content
     */
    public function addFileContent($content)
    {
        if (!is_array($content)) {
            $content = array($content);
        }
        foreach ($content as $partial) {
            $this->addGeneratorProperty('content', $partial);
        }
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     * @todo implement exception throwing if mandatory parameter is missing
     */
    public function generate()
    {
        if ($this->canBeGenerated()) {
            $this->resetContent();
            $this->addEmptyLine = false;
            $isExecutable = $this->getGeneratorProperty('is_executable', false);
            if ($isExecutable) {
                $this->addContent('#!/bin/php');
            }

            $this->addContent('<?php');
            $this->generateContent();
            $this->generateConstants();
            $this->generateProperties();
            $this->generateTraits();
            $this->generateMethods();
            $this->generateClasses();
        }

        return $this->generateStringFromContent();
    }

    private function generateContent()
    {
        $content = $this->getGeneratorProperty('content', array());

        foreach ($content as $partial) {
            $this->addContent($partial);
        }
        $this->addEmptyLine = true;
    }

    private function generateConstants()
    {
        /** @var null|ConstantGenerator[] $constants */
        $constants = $this->getGeneratorProperty('constants');

        if (is_array($constants)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = $this->getLastArrayKey($constants);
            foreach($constants as $key => $constant) {
                $this->addGeneratorAsContent($constant);
                if ($key !== $lastArrayKey) {
                    $this->addContent('');
                }
            }
            $this->addEmptyLine = true;
        }
    }

    private function generateProperties()
    {
        /** @var null|PropertyGenerator[] $properties */
        $properties = $this->getGeneratorProperty('properties');

        if (is_array($properties)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = $this->getLastArrayKey($properties);
            foreach($properties as $key => $property) {
                $this->addGeneratorAsContent($property);
                if ($key !== $lastArrayKey) {
                    $this->addContent('');
                }
            }
        }
        $this->addEmptyLine = true;
    }

    private function generateTraits()
    {
        /** @var null|array $traits */
        $traits = $this->getGeneratorProperty('traits');

        if (is_array($traits)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = $this->getLastArrayKey($traits);
            foreach($traits as $key => $trait) {
                $this->addGeneratorAsContent($trait);
                if ($key !== $lastArrayKey) {
                    $this->addContent('');
                }
            }
        }
        $this->addEmptyLine = true;
    }

    private function generateMethods()
    {
        /** @var null|MethodGenerator[] $methods */
        $methods = $this->getGeneratorProperty('methods');

        if (is_array($methods)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = $this->getLastArrayKey($methods);
            foreach($methods as $key => $method) {
                $this->addGeneratorAsContent($method);
                if ($key !== $lastArrayKey) {
                    $this->addContent('');
                }
            }
        }
        $this->addEmptyLine = true;
    }

    private function generateClasses()
    {
        /** @var null|ClassGenerator[] $classes */
        $classes = $this->getGeneratorProperty('classes');

        if (is_array($classes)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = array_pop(array_keys($classes));
            foreach($classes as $key => $class) {
                $this->addGeneratorAsContent($class);
                if ($key !== $lastArrayKey) {
                    $this->addContent('');
                }
            }
        }
    }
}