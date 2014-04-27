<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class ClassTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class ClassTemplate extends AbstractTemplate
{
    /**
     * @param string $className
     */
    public function addExtends($className)
    {
        $this->addProperty('extends', (string) $className);
    }

    /**
     * @param string $interfaceName
     */
    public function addImplements($interfaceName)
    {
        $this->addProperty('implements', (string) $interfaceName);
    }

    /**
     * @param string $fullQualifiedClassName
     * @param string $alias
     */
    public function addUse($fullQualifiedClassName, $alias = '')
    {
        $use = array(
            'alias' => $alias,
            'name'  => $fullQualifiedClassName
        );

        $this->addProperty('implements', $use);
    }

    /**
     * @param ConstantTemplate $constant
     */
    public function addConstant(ConstantTemplate $constant)
    {
        $this->addProperty('constants', $constant);
    }

    /**
     * @param MethodTemplate $method
     */
    public function addMethod(MethodTemplate $method)
    {
        $this->addProperty('methods', $method);
    }

    /**
     * @param PropertyTemplate $property
     */
    public function addProperty(PropertyTemplate $property)
    {
        $this->addProperty('properties', $property);
    }

    /**
     * @param TraitTemplate $trait
     */
    public function addTrait(TraitTemplate $trait)
    {
        $this->addProperty('traits', $trait);
    }

    /**
     * @param PhpDocumentationTemplate $phpDocumentation
     */
    public function setDocumentation(PhpDocumentationTemplate $phpDocumentation)
    {
        $this->addProperty('documentation', $phpDocumentation, false);
    }

    public function setIsAbstract()
    {
        $this->addProperty('abstract', true, false);
    }

    public function setIsFinal()
    {
        $this->addProperty('final', true, false);
    }

    public function setIsInterface()
    {
        $this->addProperty('interface', true, false);
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->addProperty('namespace', (string) $namespace, false);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fillOut()
    {
        $this->fillOutNamespace();
        $this->fillOutUse();
        $this->fillOutPhpDocumentation();
        $this->fillOutSignature();
        $this->fillOutBody();
    }

    private function fillOutBody()
    {
        $isAbstract = $this->getProperty('abstract', false);

        if (!$isAbstract) {
            $block = $this->getBlock();
            /** @var null|ConstantTemplate[] $constants */
            $constants = $this->getProperty('constants');
            /** @var null|MethodTemplate[] $methods */
            $methods = $this->getProperty('methods');
            /** @var null|PropertyTemplate[] $properties */
            $properties = $this->getProperty('properties');
            /** @var null|TraitTemplate[] $traits */
            $traits = $this->getProperty('traits');

            if (is_array($constants)) {
                foreach($constants as $constant) {
                    $block->add($constant->andConvertToString());
                    $block->add('');
                }
            }
            if (is_array($methods)) {
                foreach($methods as $method) {
                    $block->add($method->andConvertToString());
                    $block->add('');
                }
            }
            if (is_array($properties)) {
                foreach($properties as $property) {
                    $block->add($property->andConvertToString());
                    $block->add('');
                }
            }
            if (is_array($traits)) {
                foreach($traits as $trait) {
                    $block->add($trait->andConvertToString());
                    $block->add('');
                }
            }

            if ($block->hasContent()) {
                $this->addContent($block);
            }
        }
    }

    private function fillOutNamespace()
    {
        $namespace = $this->getProperty('namespace');

        if (!is_null($namespace)) {
            $this->addContent(
                $this->getBlock(
                    array(
                        'namespace ' . $namespace . ';',
                        ''
                    )
                )
            );
        }
    }

    private function fillOutPhpDocumentation()
    {
        $documentation = $this->getProperty('documentation');

        if ($documentation instanceof PhpDocumentationTemplate) {
            $this->addContent(explode(PHP_EOL, $documentation->andConvertToString()));
        }
    }

    private function fillOutSignature()
    {
        $isAbstract = $this->getProperty('abstract', false);
        $isFinal = $this->getProperty('final', false);
        $extends = $this->getProperty('extends');
        $implements = $this->getProperty('implements');
        $name = $this->getProperty('name');

        if (is_null($name)) {
            throw new RuntimeException('name is mandatory');
        }

        $line = $this->getLine();
        if ($isAbstract) {
            $line->add('abstract');
        } else if ($isFinal) {
            $line->add('final');
        }

        $line->add('class ' . $name);
        if (is_array($extends)) {
            $line->add('extends ', implode(',', $extends));
        }
        if (is_array($implements)) {
            $line->add('implements ', implode(',', $implements));
        }
    }

    private function fillOutUse()
    {
        $uses = $this->getProperty('uses');

        if (is_array($uses)) {
            $block = $this->getBlock();
            foreach ($uses as $use) {
                if (strlen($use['alias']) > 0) {
                    $block->add('use ' . $use['name'] . ' alias ' . $use['alias'] . ';');
                } else {
                    $block->add('use ' . $use['name'] . ';');
                }
            }
            $block->add('');
            $this->addContent($block);
        }
    }
}