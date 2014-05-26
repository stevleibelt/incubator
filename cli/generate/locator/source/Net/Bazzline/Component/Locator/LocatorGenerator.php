<?php
/**
 * @author sleibelt
 * @since 2014-04-24
 */

namespace Net\Bazzline\Component\Locator;

use Exception;
use Net\Bazzline\Component\CodeGenerator\ClassGenerator;
use Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\MethodGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory;
use Net\Bazzline\Component\Locator\Configuration\ConfigurationInterface;

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
     * @var ConfigurationInterface
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
     * @var MethodGeneratorFactory
     */
    private $methodFactory;

    /**
     * @var PropertyGeneratorFactory
     */
    private $propertyFactory;

    /**
     * @var string
     */
    private $outputPath;

    /**
     * @param \Net\Bazzline\Component\Locator\Configuration\ConfigurationInterface $configuration
     * @return $this
     */
    public function setConfiguration($configuration)
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
     * @param string $pathToConfigurationFile
     * @throws Exception
     */
    public function setPathToConfigurationFile($pathToConfigurationFile)
    {
        if (!is_readable($pathToConfigurationFile)) {
            throw new Exception('configuration file is not readable: "' . $pathToConfigurationFile . '"');
        }
        $configuration = require_once $pathToConfigurationFile;
        //@todo implement configuration validation
        if (!is_array($configuration)
            || empty($configuration)) {
            throw new Exception('configuration file has to be in the documented format');
        }
        $this->configuration = $configuration;
    }

    /**
     * @param string $outputPath
     * @throws Exception
     */
    public function setOutputPath($outputPath)
    {
        if (!is_writable($outputPath)) {
            throw new Exception('output directory is not writable: "' . $outputPath . '"');
        }
        $this->outputPath = (string) $outputPath;
    }

    /**
     * @throws Exception
     */
    public function generate()
    {
        $this->moveOldLocatorFileIfExists();
        $this->createLocatorFile();
    }
/*
array (
'shared_instance' =>
array (
'CookieManager' => 'Application\\Cookie\\CookieManager',
'Database' => 'Application\\Service\\Factory\\DatabaseFactory',
),
'single_instance' =>
array (
'Lock' => 'Application\\Service\\Factory\\LockFileFactory',
'LockAlias' => 'Application\\Service\\Factory\\LockFileFactory',
),
)
*/
    private function createLocatorFile()
    {
        $file = $this->fileFactory->create();

        $class = $this->createLocatorClass();

        $file->addClass($class);
        $content = $file->generate();

        if (file_put_contents($this->outputPath . DIRECTORY_SEPARATOR . $this->configuration['file_name'], $content) === false) {
            throw new Exception('can not create new locator in "' . $this->outputPath . DIRECTORY_SEPARATOR . $this->configuration['file_name']);
        }
    }

    /**
     * @return ClassGenerator
     */
    private function createLocatorClass()
    {
        $class = $this->classFactory->create();

        $class->setDocumentation($this->documentationFactory->create());
        $class->setName($this->configuration['class_name']);
        $class->setNamespace($this->configuration['namespace']);
        if (isset($this->configuration['parent_class_name'])) {
            $class->addExtends($this->configuration['parent_class_name'], true);
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
            ->setClass($this->configuration['class_name'])
            ->setPackage($this->configuration['namespace']);

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
     * @throws \Exception
     */
    private function moveOldLocatorFileIfExists()
    {
        $oldName = $this->configuration['file_name'];
        $pathToOldLocatorFile = $this->outputPath;
        if (file_exists($pathToOldLocatorFile . DIRECTORY_SEPARATOR . $oldName)) {
            $oldNameAsArray = explode('.', $oldName);
            $extension = array_pop($oldNameAsArray);
            $newName = implode('.', $oldNameAsArray) . '.' . time() . '.' . $extension;
            if (rename($pathToOldLocatorFile . DIRECTORY_SEPARATOR . $oldName, $pathToOldLocatorFile . DIRECTORY_SEPARATOR . $newName) === false) {
                throw new Exception('old locator file with name "' . $oldName . '" already exists and can not be renamed to "' . $newName . '"');
            }
        }
    }
}