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
     * @var FileExistsStrategyInterface
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
        if ($this->configuration->hasExtends()) {
            $class->setExtends($this->configuration->getExtends(), true);
        }

        $class->addImplements('\Net\Bazzline\Component\Locator\LocatorInterface');
        $class = $this->addDocumentationToClass($class);
        $class = $this->addPropertiesToClass($class);

        //create instance pooling methods
        //---- begin of factory instance pooling
        $class = $this->addMethodToFetchFromFactoryInstancePool($class);
        $class = $this->addMethodToAddToFactoryInstancePool($class);
        $class = $this->addMethodToGetFromFactoryInstancePool($class);
        $class = $this->addMethodIsNotInFactoryInstancePool($class);
        //---- end of factory instance pooling
        //---- begin of shared instance pooling
        $class = $this->addMethodToFetchFromSharedInstancePool($class);
        $class = $this->addMethodToAddToSharedInstancePool($class);
        $class = $this->addMethodToGetFromSharedInstancePool($class);
        $class = $this->addMethodIsNotInSharedInstancePool($class);
        //---- end of shared instance pooling
        //create method for shared_instance
        //create method for single_instance

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToFetchFromFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('fetchFromFactoryInstancePool');
        $method->addParameter('className', null, 'string');

        $body
            ->add('if ($this->isNotInFactoryInstancePool($className)) {')
            ->startIndention()
                ->add('if (!class_exists($className)) {')
                ->startIndention()
                    ->add('throw new InvalidArgumentException(')
                    ->startIndention()
                        ->add('\'factory class "\' . $className . \'" does not exist\'')
                    ->stopIndention()
                    ->add(');')
                ->stopIndention()
                ->add('}')
                ->add('')
                ->add('/** @var FactoryInterface $factory */')
                ->add('$factory = new $className();')
                ->add('$factory->setLocator($this);')
                ->add('$this->addToFactoryInstancePool($className, $factory);')
            ->stopIndention()
            ->add('}')
            ->add('')
            ->add('return $this->getFromFactoryInstancePool($className);');

        $method->setBody($body, array('FactoryInterface'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToAddToFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('addToFactoryInstancePool');
        $method->addParameter('className', null, 'string');
        $method->addParameter('factory', null, 'FactoryInterface');

        $body
            ->add('$this->factoryInstancePool[$className] = $factory;')
            ->add('')
            ->add('return $this;');

        $method->setBody($body, array('$this'));

        $class->addMethod($method);
        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToGetFromFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('getFromFactoryInstancePool');
        $method->addParameter('className', null, 'string');

        $body
            ->add('return $this->factoryInstancePool[$className];');

        $method->setBody($body, array('FactoryInterface'));

        $class->addMethod($method);
        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodIsNotInFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('isNotInFactoryInstancePool');
        $method->addParameter('className', null, 'string');

        $body
            ->add('return (!isset($this->factoryInstancePool[$className]));');

        $method->setBody($body, array('bool'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodIsNotInSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('isNotInSharedInstancePool');
        $method->addParameter('className', null, 'string');

        $body
            ->add('return (!isset($this->sharedInstancePool[$className]));');

        $method->setBody($body, array('bool'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToGetFromSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('getFromSharedInstancePool');
        $method->addParameter('className', null, 'string');

        $body
            ->add('return $this->sharedInstancePool[$className];');

        $method->setBody($body, array('mixed', 'object'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToFetchFromSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('fetchFromSharedInstancePool');
        $method->addParameter('className', null, 'string');

        $body
            ->add('if ($this->isNotInFactoryInstancePool($className)) {')
            ->startIndention()
                ->add('if (!class_exists($className)) {')
                ->startIndention()
                    ->add('throw new InvalidArgumentException(')
                    ->startIndention()
                        ->add('\'class "\' . $className . \'" does not exist\'')
                    ->stopIndention()
                    ->add(');')
                ->stopIndention()
                ->add('}')
                ->add('')
                ->add('$instance = new $className();')
                ->add('$this->addToFactoryInstancePool($className, $instance);')
            ->stopIndention()
            ->add('}')
            ->add('')
            ->add('return $this->getFromSharedInstancePool($className);');

        $method->setBody($body, array('null', 'object'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToAddToSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockFactory->create();
        $method = $this->methodFactory->create();

        $method->setDocumentation($this->documentationFactory->create());
        $method->setName('addToSharedInstancePool');
        $method->addParameter('className', null, 'string');
        $method->addParameter('instance', null, 'object');

        $body
            ->add('$this->sharedInstancePool[$className] = $instance;')
            ->add('')
            ->add('return $this;');

        $method->setBody($body, array('$this'));

        $class->addMethod($method);

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

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addPropertiesToClass(ClassGenerator $class)
    {
        $factoryInstancePool = $this->propertyFactory->create();
        $sharedInstancePool = $this->propertyFactory->create();

        $factoryInstancePool->setDocumentation($this->documentationFactory->create());
        $factoryInstancePool->setName('factoryInstancePool');
        $factoryInstancePool->markAsPrivate();
        $factoryInstancePool->setValue('array()');

        $sharedInstancePool->setDocumentation($this->documentationFactory->create());
        $sharedInstancePool->setName('sharedInstancePool');
        $sharedInstancePool->markAsPrivate();
        $sharedInstancePool->setValue('array()');

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