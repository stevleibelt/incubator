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
    public function addFileConstant(ConstantGenerator $constant)
    {
        $this->addProperty('constants', $constant);
    }

    /**
     * @param PropertyGenerator $property
     */
    public function addFileProperty(PropertyGenerator $property)
    {
        $this->addProperty('properties', $property);
    }

    /**
     * @param ClassGenerator $class
     */
    public function addClass(ClassGenerator $class)
    {
        $this->addProperty('classes', $class);
    }

    /**
     * @param MethodGenerator $method
     */
    public function addMethod(MethodGenerator $method)
    {
        $this->addProperty('methods', $method);
    }

    /**
     * @param TraitGenerator $trait
     */
    public function addTrait(TraitGenerator $trait)
    {
        $this->addProperty('traits', $trait->getName());
    }

    public function markAsExecutable()
    {
        $this->addProperty('is_executable', true, false);
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
            $this->addProperty('content', $partial);
        }
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        if ($this->canBeGenerated()) {
            $this->addEmptyLine = false;
            $isExecutable = $this->getProperty('is_executable', false);
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
        $content = $this->getProperty('content', array());

        foreach ($content as $partial) {
            $this->addContent($partial);
        }
        $this->addEmptyLine = true;
    }

    private function generateConstants()
    {
        /** @var null|ConstantGenerator[] $constants */
        $constants = $this->getProperty('constants');

        if (is_array($constants)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = array_pop(array_keys($constants));
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
        $properties = $this->getProperty('properties');

        if (is_array($properties)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = array_pop(array_keys($properties));
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
        $traits = $this->getProperty('traits');

        if (is_array($traits)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = array_pop(array_keys($traits));
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
        $methods = $this->getProperty('methods');

        if (is_array($methods)) {
            if ($this->addEmptyLine) {
                $this->addContent('');
            }
            $lastArrayKey = array_pop(array_keys($methods));
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
        $classes = $this->getProperty('classes');

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