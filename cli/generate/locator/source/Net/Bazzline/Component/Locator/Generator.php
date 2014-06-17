<?php
/**
 * @author sleibelt
 * @since 2014-04-24
 */

namespace Net\Bazzline\Component\Locator;

use Net\Bazzline\Component\CodeGenerator\ClassGenerator;
use Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\FileGenerator;
use Net\Bazzline\Component\Locator\FileExistsStrategy\FileExistsStrategyInterface;

/**
 * Class Generator
 *
 * @package Net\Bazzline\Component\Locator
 * @todo refactor methods to inject all needed properties instead of using private/protected ones
 * @todo split generation into three generators (Generator, FactoryInterfaceGenerator, InvalidArgumentExceptionGenerator), rename this one to "Generator"
 */
class Generator extends AbstractGenerator
{
    /**
     * @throws RuntimeException
     */
    public function generate()
    {
        if (!is_dir($this->configuration->getFilePath())) {
            throw new RuntimeException(
                'provided path "' . $this->configuration->getFilePath() . '" is not a directory'
            );
        }

        if (!is_writable($this->configuration->getFilePath())) {
            throw new RuntimeException(
                'provided directory "' . $this->configuration->getFilePath() . '" is not writable'
            );
        }

        $this->moveOldLocatorFileIfExists($this->configuration);
        $this->createLocatorFile($this->configuration, $this->fileGeneratorFactory->create());

        if ($this->configuration->hasFactoryInstances()) {
            $this->moveOldFactoryInterfaceFileIfExists($this->configuration);
            $this->createFactoryInterfaceFile($this->configuration, $this->fileGeneratorFactory->create());
        }

        if (($this->configuration->hasFactoryInstances())
            || ($this->configuration->hasSharedInstances())) {
            $this->moveOldInvalidArgumentExceptionFileIfExists($this->configuration);
            $this->createInvalidArgumentExceptionFile($this->configuration, $this->fileGeneratorFactory->create());
        }
    }

    /**
     * @param Configuration $configuration
     * @param FileGenerator $file
     * @throws RuntimeException
     */
    private function createLocatorFile(Configuration $configuration, FileGenerator $file)
    {
        $fullQualifiedPathName = $configuration->getFilePath() .
            DIRECTORY_SEPARATOR . $configuration->getFileName();

        $file->addFileContent(
            array(
                '/**',
                ' * @author Net\Bazzline\Component\Locator',
                ' * @since ' . date('Y-m-d'),
                ' */'
            )
        );

        $locator = $this->createLocatorClass();

        $file->addClass($locator);

        $content = $file->generate();

        $this->dumpToFile($fullQualifiedPathName, $content);
    }

    /**
     * @param Configuration $configuration
     * @param FileGenerator $file
     * @throws RuntimeException
     */
    private function createFactoryInterfaceFile(Configuration $configuration, FileGenerator $file)
    {
        $fullQualifiedPathName = $configuration->getFilePath() .
            DIRECTORY_SEPARATOR . 'FactoryInterface.php';

        $file->addFileContent(
            array(
                '/**',
                ' * @author Net\Bazzline\Component\Locator',
                ' * @since ' . date('Y-m-d'),
                ' */'
            )
        );

        $factoryInterface = $this->createFactoryInterface();

        $file->addClass($factoryInterface);

        $content = $file->generate();

        $this->dumpToFile($fullQualifiedPathName, $content);
    }

    /**
     * @param Configuration $configuration
     * @param FileGenerator $file
     * @throws RuntimeException
     */
    private function createInvalidArgumentExceptionFile(Configuration $configuration, FileGenerator $file)
    {
        $fullQualifiedPathName = $configuration->getFilePath() .
            DIRECTORY_SEPARATOR . 'InvalidArgumentException.php';

        $file->addFileContent(
            array(
                '/**',
                ' * @author Net\Bazzline\Component\Locator',
                ' * @since ' . date('Y-m-d'),
                ' */'
            )
        );

        $invalidArgumentException = $this->createInvalidArgumentExceptionClass();

        $file->addClass($invalidArgumentException);

        $content = $file->generate();

        $this->dumpToFile($fullQualifiedPathName, $content);
    }

    /**
     * @param string $fullQualifiedFileName
     * @param string $content
     * @throws RuntimeException
     */
    private function dumpToFile($fullQualifiedFileName, $content)
    {
        if (file_put_contents($fullQualifiedFileName, $content) === false) {
            throw new RuntimeException(
                'can not create "' . $fullQualifiedFileName . '" or write content'
            );
        }
    }

    /**
     * @return ClassGenerator
     */
    private function createFactoryInterface()
    {
        $class = $this->classGeneratorFactory->create();

        $class->markAsInterface();
        $class->setDocumentation($this->documentationGeneratorFactory->create());
        $class->setName('FactoryInterface');

        //@tod put into separate method
        if ($this->configuration->hasNamespace()) {
            $class->setNamespace($this->configuration->getNamespace());
        }

        $setLocator = $this->methodGeneratorFactory->create();
        $setLocator->setDocumentation($this->documentationGeneratorFactory->create());
        $setLocator->setName('setLocator');
        $setLocator->addParameter('locator', null, $this->configuration->getClassName());
        $setLocator->markAsPublic();
        $setLocator->markAsHasNoBody();
        $setLocator->getDocumentation()->setReturn(array('$this'));

        $create = $this->methodGeneratorFactory->create();
        $create->setDocumentation($this->documentationGeneratorFactory->create());
        $create->setName('create');
        $create->markAsPublic();
        $create->markAsHasNoBody();
        $create->getDocumentation()->setReturn(array('null', 'object'));

        $class->addMethod($setLocator);
        $class->addMethod($create);

        return $class;
    }

    /**
     * @return ClassGenerator
     */
    private function createInvalidArgumentExceptionClass()
    {
        $class = $this->classGeneratorFactory->create();

        $class->setDocumentation($this->documentationGeneratorFactory->create());
        $class->setName('InvalidArgumentException');

        //@tod put into separate method
        if ($this->configuration->hasNamespace()) {
            $class->setNamespace($this->configuration->getNamespace());
        }

        $class->addUse('InvalidArgumentException', 'ParentClass');
        $class->setExtends('ParentClass');

        return $class;
    }

    /**
     * @return ClassGenerator
     */
    private function createLocatorClass()
    {
        $class = $this->classGeneratorFactory->create();

        $class->setDocumentation($this->documentationGeneratorFactory->create());
        $class->setName($this->configuration->getClassName());

        if ($this->configuration->hasNamespace()) {
            $class->setNamespace($this->configuration->getNamespace());
        }
        if ($this->configuration->hasExtends()) {
            $class->setExtends($this->configuration->getExtends());
        }
        if ($this->configuration->hasUses()) {
            foreach ($this->configuration->getUses() as $use) {
                $class->addUse($use->getClassName(), $use->getAlias());
            }
        }
        if ($this->configuration->hasImplements()) {
            foreach ($this->configuration->getImplements() as $interfaceName) {
                $class->addImplements($interfaceName);
            }
        }

        $class = $this->addDocumentationToClass($class, $this->configuration);
        $class = $this->addPropertiesToClass($class, $this->documentationGeneratorFactory, $this->propertyGeneratorFactory);

        //public methods
        //extend injection token todo
        $class = $this->addGetInstanceMethods($class, $this->configuration);

        //protected methods
        if ($this->configuration->hasFactoryInstances()) {
            $class = $this->addMethodToFetchFromFactoryInstancePool($class, $this->configuration);
        }

        if ($this->configuration->hasSharedInstances()) {
            $class = $this->addMethodToFetchFromSharedInstancePool($class, $this->configuration);
        }

        //private methods
        if ($this->configuration->hasFactoryInstances()) {
            $class = $this->addMethodToAddToFactoryInstancePool($class, $this->configuration);
            $class = $this->addMethodToGetFromFactoryInstancePool($class, $this->configuration);
            $class = $this->addMethodIsNotInFactoryInstancePool($class, $this->configuration);
        }

        if ($this->configuration->hasSharedInstances()) {
            $class = $this->addMethodToAddToSharedInstancePool($class, $this->configuration);
            $class = $this->addMethodToGetFromSharedInstancePool($class, $this->configuration);
            $class = $this->addMethodIsNotInSharedInstancePool($class, $this->configuration);
        }

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @param Configuration $configuration
     * @return ClassGenerator
     */
    private function addGetInstanceMethods(ClassGenerator $class, Configuration $configuration)
    {
        if ($configuration->hasInstances()) {
            foreach ($configuration->getInstances() as $instance) {
                $body = $this->blockGeneratorFactory->create();
                $isUniqueInvokableInstance = ((!$instance->isFactory()) && (!$instance->isShared()));
                $isUniqueInvokableFactorizedInstance = (($instance->isFactory()) && (!$instance->isShared()));
                $isSharedInvokableInstance = ((!$instance->isFactory()) && ($instance->isShared()));
                $isSharedInvokableFactorizedInstance = (($instance->isFactory()) && ($instance->isShared()));
                $method = $this->methodGeneratorFactory->create();
                $returnValue = ($instance->hasReturnValue()) ? $instance->getReturnValue() : $instance->getClassName();

                if ($instance->hasAlias()) {
                    $methodName = $instance->getAlias();
                } else {
                    $methodName = (str_replace('\\', '' , $instance->getClassName()));
                }
                $methodName = $configuration->getMethodPrefix() . ucfirst($methodName);

                $method->setDocumentation($this->documentationGeneratorFactory->create());
                $method->setName($methodName);
                $method->markAsPublic();

                if ($isUniqueInvokableInstance) {
                    $body
                        ->add('return new ' . $instance->getClassName() . '();');
                } else if ($isUniqueInvokableFactorizedInstance) {
                    $body
                        ->add('return $this->fetchFromFactoryInstancePool(\'' . $instance->getClassName() . '\')->create();');
                } else if ($isSharedInvokableInstance) {
                    $body
                        ->add('return $this->fetchFromSharedInstancePool(\'' . $instance->getClassName() . '\');');
                } else if ($isSharedInvokableFactorizedInstance) {
                    $body
                        ->add('$className = \'' . $instance->getClassName() . '\';')
                        ->add('')
                        ->add('if ($this->isNotInSharedInstancePool($className)) {')
                        ->startIndention()
                            ->add('$factoryClassName = \'' . $instance->getClassName() . '\';')
                            ->add('$factory = $this->fetchFromFactoryInstancePool($factoryClassName);')
                            ->add('')
                            ->add('$this->addToSharedInstancePool($className, $factory->create());')
                        ->stopIndention()
                        ->add('}')
                        ->add('')
                        ->add('return $this->fetchFromSharedInstancePool($className);');
                }

                $method->setBody($body, array($returnValue));

                $class->addMethod($method);
            }
        }

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToFetchFromFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('fetchFromFactoryInstancePool');
        $method->addParameter('className', null, 'string');
        $method->markAsProtected();
        $method->markAsFinal();

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
        $method->getDocumentation()->addThrows('InvalidArgumentException');

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToAddToFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('addToFactoryInstancePool');
        $method->addParameter('className', null, 'string');
        $method->addParameter('factory', null, 'FactoryInterface');
        $method->markAsPrivate();

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
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('getFromFactoryInstancePool');
        $method->addParameter('className', null, 'string');
        $method->markAsPrivate();

        $body
            ->add('return $this->factoryInstancePool[$className];');

        $method->setBody($body, array('null', 'FactoryInterface'));

        $class->addMethod($method);
        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodIsNotInFactoryInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('isNotInFactoryInstancePool');
        $method->addParameter('className', null, 'string');
        $method->markAsPrivate();

        $body
            ->add('return (!isset($this->factoryInstancePool[$className]));');

        $method->setBody($body, array('boolean'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodIsNotInSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('isNotInSharedInstancePool');
        $method->addParameter('className', null, 'string');
        $method->markAsPrivate();

        $body
            ->add('return (!isset($this->sharedInstancePool[$className]));');

        $method->setBody($body, array('boolean'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToGetFromSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('getFromSharedInstancePool');
        $method->addParameter('className', null, 'string');
        $method->markAsPrivate();

        $body
            ->add('return $this->sharedInstancePool[$className];');

        $method->setBody($body, array('null', 'object'));

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToFetchFromSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('fetchFromSharedInstancePool');
        $method->addParameter('className', null, 'string');
        $method->markAsProtected();
        $method->markAsFinal();

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

        $method->setBody($body, array('object'));
        $method->getDocumentation()->addThrows('InvalidArgumentException');

        $class->addMethod($method);

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @return ClassGenerator
     */
    private function addMethodToAddToSharedInstancePool(ClassGenerator $class)
    {
        $body = $this->blockGeneratorFactory->create();
        $method = $this->methodGeneratorFactory->create();

        $method->setDocumentation($this->documentationGeneratorFactory->create());
        $method->setName('addToSharedInstancePool');
        $method->addParameter('className', null, 'string');
        $method->addParameter('instance', null, 'object');
        $method->markAsPrivate();

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
     * @param Configuration $configuration
     * @return ClassGenerator
     */
    private function addDocumentationToClass(ClassGenerator $class, Configuration $configuration)
    {
        $class->getDocumentation()
            ->setClass($configuration->getClassName())
            ->setPackage($configuration->getNamespace());

        return $class;
    }

    /**
     * @param ClassGenerator $class
     * @param DocumentationGeneratorFactory $documentationGeneratorFactory
     * @param PropertyGeneratorFactory $propertyGeneratorFactory
     * @return ClassGenerator
     */
    private function addPropertiesToClass(ClassGenerator $class, DocumentationGeneratorFactory $documentationGeneratorFactory, PropertyGeneratorFactory $propertyGeneratorFactory)
    {
        if ($this->configuration->hasFactoryInstances()) {
            $factoryInstancePool = $propertyGeneratorFactory->create();

            $factoryInstancePool->setDocumentation($documentationGeneratorFactory->create());
            $factoryInstancePool->setName('factoryInstancePool');
            $factoryInstancePool->markAsPrivate();
            $factoryInstancePool->setValue('array()');

            $class->addProperty($factoryInstancePool);
        }

        if ($this->configuration->hasSharedInstances()) {
            $sharedInstancePool = $propertyGeneratorFactory->create();

            $sharedInstancePool->setDocumentation($documentationGeneratorFactory->create());
            $sharedInstancePool->setName('sharedInstancePool');
            $sharedInstancePool->markAsPrivate();
            $sharedInstancePool->setValue('array()');

            $class->addProperty($sharedInstancePool);
        }

        return $class;
    }

    /**
     * @param Configuration $configuration
     * @throws RuntimeException
     */
    private function moveOldLocatorFileIfExists(Configuration $configuration)
    {
        $this->moveOldFileIfExists($configuration->getFilePath(), $configuration->getFileName());
    }

    /**
     * @param Configuration $configuration
     */
    private function moveOldFactoryInterfaceFileIfExists(Configuration $configuration)
    {
        $this->moveOldFileIfExists($configuration->getFilePath(), 'FactoryInterface.php');
    }

    /**
     * @param Configuration $configuration
     */
    private function moveOldInvalidArgumentExceptionFileIfExists(Configuration $configuration)
    {
        $this->moveOldFileIfExists($configuration->getFilePath(), 'InvalidArgumentException.php');
    }
}
