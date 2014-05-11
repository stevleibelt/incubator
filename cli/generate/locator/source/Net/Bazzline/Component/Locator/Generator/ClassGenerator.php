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
     * @return string
     */
    public function generate()
    {
        $this->generateNamespace();
        $this->generateUse();
        $this->generateDocumentation();
        $this->generateSignature();
        $this->generateBody();

        return $this->generateStringFromContent();
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
        /** @var null|array $traits */
        $traits = $this->getProperty('traits');

        if (is_array($traits)) {
            $this->addContent('use ' . implode(',', $traits) . ';', true);
            $this->addContent('');
        }
        if (is_array($constants)) {
            foreach($constants as $constant) {
                $this->addGeneratorAsContent($constant, true);
                $this->addContent('');
            }
        }
        if (is_array($properties)) {
            foreach($properties as $property) {
                $this->addGeneratorAsContent($property, true);
                $this->addContent('');
            }
        }
        if (is_array($methods)) {
            foreach($methods as $method) {
                $this->addGeneratorAsContent($method, true);
                $this->addContent('');
            }
        }

        $this->addContent('}');
    }

    private function generateNamespace()
    {
        $namespace = $this->getProperty('namespace');

        if (!is_null($namespace)) {
            $this->addContent(
                $this->getLineGenerator(
                    'namespace ' . $namespace . ';'
                )
            );
            $this->addContent(
                $this->getLineGenerator(
                    ''
                )
            );
        }
    }

    private function generateDocumentation()
    {
        $documentation = $this->getProperty('documentation');

        if ($documentation instanceof DocumentationGenerator) {
            $this->addGeneratorAsContent($documentation);
            $documentation->clear();
        }
    }

    /**
     * @throws \Net\Bazzline\Component\Locator\Generator\RuntimeException
     */
    private function generateSignature()
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

        $line = $this->getLineGenerator();
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

    private function generateUse()
    {
        $uses = $this->getProperty('uses');

        if (is_array($uses)) {
            foreach ($uses as $use) {
                $line = $this->getLineGenerator();
                if (strlen($use['alias']) > 0) {
                    $line->add('use ' . $use['name'] . ' as ' . $use['alias'] . ';');
                } else {
                    $line->add('use ' . $use['name'] . ';');
                }
                $this->addContent($line);
            }
            $line = $this->getLineGenerator();
            $line->add('');
            $this->addContent($line);
        }
    }
}