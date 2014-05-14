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
    public function addContent($content)
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
    }

    private function generateConstants()
    {
        /** @var null|ConstantGenerator[] $constants */
        $constants = $this->getProperty('constants');

        if (is_array($constants)) {
            foreach($constants as $constant) {
                $this->addGeneratorAsContent($constant, true);
                $this->addContent('');
            }
        }
    }

    private function generateProperties()
    {
        /** @var null|PropertyGenerator[] $properties */
        $properties = $this->getProperty('properties');

        if (is_array($properties)) {
            foreach($properties as $property) {
                $this->addGeneratorAsContent($property, true);
                $this->addContent('');
            }
        }
    }

    private function generateTraits()
    {
        /** @var null|array $traits */
        $traits = $this->getProperty('traits');

        if (is_array($traits)) {
            foreach($traits as $trait) {
                $this->addGeneratorAsContent($trait, true);
                $this->addContent('');
            }
        }
    }

    private function generateMethods()
    {
        /** @var null|MethodGenerator[] $methods */
        $methods = $this->getProperty('methods');

        if (is_array($methods)) {
            foreach($methods as $method) {
                $this->addGeneratorAsContent($method, true);
                $this->addContent('');
            }
        }
    }

    private function generateClasses()
    {
        /** @var null|ClassGenerator[] $classes */
        $classes = $this->getProperty('classes');

        if (is_array($classes)) {
            foreach($classes as $class) {
                $this->addGeneratorAsContent($class, true);
                $this->addContent('');
            }
        }
    }
}