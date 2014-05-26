<?php
/**
 * @author sleibelt
 * @since 2014-04-24
 */

namespace Net\Bazzline\Component\Locator;

use Net\Bazzline\Component\CodeGenerator\ClassGenerator;
use Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\MethodGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\FileGenerator;
use Net\Bazzline\Component\Locator\FileExistsStrategy\FileExistsStrategyInterface;

/**
 * Class LocatorGenerator
 *
 * @package Net\Bazzline\Component\Locator
 */
class LocatorGenerator
{
    /**
     * @var BlockGeneratorFactory
     */
    private $blockFactory;

    /**
     * @var ClassGeneratorFactory
     */
    private $classFactory;

    /**
     * @var \Net\Bazzline\Component\Locator\Configuration
     */
    private $configuration;

    /**
     * @var DocumentationGeneratorFactory
     */
    private $documentationFactory;

    /**
     * @var FileGeneratorFactory
     */
    private $fileFactory;

    /**
     * @var FileExsistStrategyInterface
     */
    private $fileExistsStrategy;

    /**
     * @var MethodGeneratorFactory
     */
    private $methodFactory;

    /**
     * @var PropertyGeneratorFactory
     */
    private $propertyFactory;

    /**
     * @param \Net\Bazzline\Component\Locator\Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory $documentationFactory
     * @return $this
     */
    public function setDocumentationFactory($documentationFactory)
    {
        $this->documentationFactory = $documentationFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory $fileFactory
     * @return $this
     */
    public function setFileFactory($fileFactory)
    {
        $this->fileFactory = $fileFactory;

        return $this;
    }

    /**
     * @param FileExistsStrategyInterface $strategy
     * @return $this
     */
    public function setFileExistsStrategy(FileExistsStrategyInterface $strategy)
    {
        $this->fileExistsStrategy = $strategy;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\MethodGeneratorFactory $methodFactory
     * @return $this
     */
    public function setMethodFactory($methodFactory)
    {
        $this->methodFactory = $methodFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory $propertyFactory
     * @return $this
     */
    public function setPropertyFactory($propertyFactory)
    {
        $this->propertyFactory = $propertyFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory $classFactory
     * @return $this
     */
    public function setClassFactory($classFactory)
    {
        $this->classFactory = $classFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory $blockFactory
     * @return $this
     */
    public function setBlockFactory($blockFactory)
    {
        $this->blockFactory = $blockFactory;

        return $this;
    }

    /**
     * @throws RuntimeException
     */
    public function generate()
    {
        $this->moveOldLocatorFileIfExists();
        $this->createLocatorFile();
    }

    /**
     * @throws RuntimeException
     */
    private function createLocatorFile()
    {
        $file = $this->fileFactory->create();

        $class = $this->createLocatorClass();
        $file->addClass($class);
        $content = $file->generate();

        $this->dumpToFile($content);
    }

    /**
     * @param string $content
     * @throws RuntimeException
     */
    private function dumpToFile($content)
    {
        $filePath = $this->configuration->getFilePath() . DIRECTORY_SEPARATOR .
            $this->configuration->getFileName();

        if (file_put_contents($filePath, $content) === false) {
            throw new RuntimeException(
                'can not create new locator in "' . $filePath . '"'
            );
        }
    }

    /**
     * @return ClassGenerator
     */
    private function createLocatorClass()
    {
        $class = $this->classFactory->create();

        $class->setDocumentation($this->documentationFactory->create());
        $class->setName($this->configuration->getClassName());
        if ($this->configuration->hasNamespace()) {
            $class->setNamespace($this->configuration->getNamespace());
        }
        if ($this->configuration->hasParentClassName()) {
            $class->addExtends($this->configuration->getParentClassName(), true);
        }

        $class = $this->addDocumentationToClass($class);
        $class = $this->addPropertiesToClass($class);
        $class = $this->addMethodIsInInstancePoolToClass($class);
        $class = $this->addMethodGetFactoryToClass($class);

        //create instance pooling methods
        //create method for shared_instance
        //create method for single_instance

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addDocumentationToClass(ClassGenerator $class)
    {
        $class->getDocumentation()
            ->setClass($this->configuration->getClassName())
            ->setPackage($this->configuration->getNamespace());

        return $class;
    }

    private function addMethodGetFactoryToClass(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('getFactory');
        $method->addParameter('className', null, 'string');

        $body
            ->add('$key = md5($className);')
            ->add('')
            ->add('if ($this->isInInstancePool($className) {')
            ->startIndention()
                ->add('$factory = $this->factoryInstancePool[$className];')
            ->stopIndention()
            ->add('} else {')
            ->startIndention()
                ->add('$factory = new $className();')
                ->add('$this->factoryInstancePool[$className] = $factory;')
            ->stopIndention()
            ->add('}')
            ->add('')
            ->add('return $factory;');

        $method->setBody($body, array('FactoryInterface'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodIsInInstancePoolToClass(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('isInInstancePool');
        $method->addParameter('key', '', 'string');
        $method->addParameter('type', '', 'string');

        $body->add('switch ($type) {')
            ->startIndention()
                ->add('case \'factory\':')
                ->startIndention()
                    ->add('return (isset($this->factoryInstancePool[$key]));')
                    ->add('break;')
                ->stopIndention()
                ->add('case \'shared\':')
                ->startIndention()
                    ->add('return (isset($this->sharedInstancePool[$key]));')
                    ->add('break;')
                ->stopIndention()
                ->add('default:')
                ->startIndention()
                    ->add('return (isset($this->defaultInstancePool[$key]));')
                    ->add('break')
                ->stopIndention()
            ->stopIndention()
            ->add('}');
        $method->setBody($body);

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addPropertiesToClass(ClassGenerator $class)
    {
        $defaultInstancePool = $this->propertyFactory->create();
        $factoryInstancePool = $this->propertyFactory->create();
        $sharedInstancePool = $this->propertyFactory->create();

        $defaultInstancePool->setDocumentation($this->documentationFactory->create());
        $defaultInstancePool->setName('defaultInstancePool');
        $defaultInstancePool->markAsPrivate();
        $defaultInstancePool->setValue('array()');

        $factoryInstancePool->setDocumentation($this->documentationFactory->create());
        $factoryInstancePool->setName('factoryInstancePool');
        $factoryInstancePool->markAsPrivate();
        $factoryInstancePool->setValue('array()');

        $sharedInstancePool->setDocumentation($this->documentationFactory->create());
        $sharedInstancePool->setName('sharedInstancePool');
        $sharedInstancePool->markAsPrivate();
        $sharedInstancePool->setValue('array()');

        $class->addProperty($defaultInstancePool);
        $class->addProperty($factoryInstancePool);
        $class->addProperty($sharedInstancePool);

        return $class;
    }

    /**
     * @throws RuntimeException
     */
    private function moveOldLocatorFileIfExists()
    {
        $filePath = $this->configuration->getFilePath() . DIRECTORY_SEPARATOR .
            $this->configuration->getFileName();

        if (file_exists($filePath)) {
            if ($this->fileExistsStrategy instanceof FileExistsStrategyInterface) {
                $this->fileExistsStrategy
                    ->setFileName($this->configuration->getFileName())
                    ->setFilePath($this->configuration->getFilePath())
                    ->execute();
            } else {
                throw new RuntimeException(
                    'file "' . $filePath . '" already exists'
                );
            }
        }
    }
}