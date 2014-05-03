<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class ClassGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class ClassGenerator extends AbstractDocumentedGenerator
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

        $this->addProperty('uses', $use);
    }

    /**
     * @param ConstantGenerator $constant
     */
    public function addClassConstant(ConstantGenerator $constant)
    {
        $this->addProperty('constants', $constant);
    }

    /**
     * @param PropertyGenerator $property
     */
    public function addClassProperty(PropertyGenerator $property)
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
     * @param TraitGenerator $trait
     */
    public function addTrait(TraitGenerator $trait)
    {
        $this->addProperty('traits', $trait->getName());
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->addProperty('name', (string) $name, false);
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
        $this->addContent('{');
        /** @var null|ConstantGenerator[] $constants */
        $constants = $this->getProperty('constants');
        /** @var null|MethodGenerator[] $methods */
        $methods = $this->getProperty('methods');
        /** @var null|PropertyGenerator[] $properties */
        $properties = $this->getProperty('properties');
        /** @var null|array $traits */
        $traits = $this->getProperty('traits');

        if (is_array($traits)) {
            $this->addContent('use ' . implode(',', $traits) . ';', true);
            $this->addContent('');
        }
        if (is_array($constants)) {
            foreach($constants as $constant) {
                $constant->fillOut();
                $this->addGeneratorAsContent($constant, true);
                $this->addContent('');
            }
        }
        if (is_array($properties)) {
            foreach($properties as $property) {
                $property->fillOut();
                $this->addGeneratorAsContent($property, true);
                $this->addContent('');
            }
        }
        if (is_array($methods)) {
            foreach($methods as $method) {
                $method->fillOut();
                $this->addGeneratorAsContent($method, true);
                $this->addContent('');
            }
        }

        $this->addContent('}');
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

        if ($documentation instanceof DocumentationGenerator) {
            $documentation->fillOut();
            $this->addGeneratorAsContent($documentation);
        }
    }

    /**
     * @throws \Net\Bazzline\Component\Locator\Generator\RuntimeException
     */
    private function fillOutSignature()
    {
        $isAbstract     = $this->getProperty('abstract', false);
        $isInterface    = $this->getProperty('interface', false);
        $isFinal        = $this->getProperty('final', false);
        $extends        = $this->getProperty('extends');
        $implements     = $this->getProperty('implements');
        $name           = $this->getProperty('name');

        if (is_null($name)) {
            throw new RuntimeException('name is mandatory');
        }

        $line = $this->getLine();
        if ($isAbstract) {
            $line->add('abstract');
        } else if ($isInterface) {
            $line->add('interface');
        } else if ($isFinal) {
            $line->add('final');
        }

        $line->add('class ' . $name);
        if (is_array($extends)) {
            $line->add('extends');
            $line->add(implode(',', $extends));
        }
        if (is_array($implements)) {
            $line->add('implements');
            $line->add(implode(',', $implements));
        }
        $this->addContent($line);
    }

    private function fillOutUse()
    {
        $uses = $this->getProperty('uses');

        if (is_array($uses)) {
            $block = $this->getBlock();
            foreach ($uses as $use) {
                if (strlen($use['alias']) > 0) {
                    $block->add('use ' . $use['name'] . ' as ' . $use['alias'] . ';');
                } else {
                    $block->add('use ' . $use['name'] . ';');
                }
            }
            $block->add('');
            $this->addContent($block);
        }
    }
}