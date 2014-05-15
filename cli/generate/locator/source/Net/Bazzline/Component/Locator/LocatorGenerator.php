<?php
/**
 * @author sleibelt
 * @since 2014-04-24
 */

namespace Net\Bazzline\Component\Locator;

use Exception;
use Net\Bazzline\Component\Locator\Generator\ClassGenerator;
use Net\Bazzline\Component\Locator\Generator\Indention;
use Net\Bazzline\Component\Locator\Generator\MethodGenerator;
use Net\Bazzline\Component\Locator\Generator\DocumentationGenerator;
use Net\Bazzline\Component\Locator\Generator\PropertyGenerator;

/**
 * Class LocatorGenerator
 *
 * @package Net\Bazzline\Component\Locator
 */
class LocatorGenerator
{
    /** @var array */
    private $configuration;

    /** @var Indention */
    private $indention;

    /** @var string */
    private $outputPath;

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
        $this->indention = new Indention();
        $class = new ClassGenerator($this->indention);
        //@todo move into methods like: $class = $this->enrichWithDocumentation($class)
        $documentation = $this->createNewDocumentationGenerator();
        $documentation->setClass($this->configuration['class_name']);
        $documentation->setPackage($this->configuration['namespace']);

        $factoryInstancePool = new PropertyGenerator($this->indention);
        $factoryInstancePool->setDocumentation($this->createNewDocumentationGenerator());
        $factoryInstancePool->setName('factoryInstancePool');
        $factoryInstancePool->markAsPrivate();
        $factoryInstancePool->setValue('array()');

        $sharedInstancePool = new PropertyGenerator($this->indention);
        $sharedInstancePool->setDocumentation($this->createNewDocumentationGenerator());
        $sharedInstancePool->setName('sharedInstancePool');
        $sharedInstancePool->markAsPrivate();
        $sharedInstancePool->setValue('array()');

        $isInInstancePool = new MethodGenerator($this->indention);
        $isInInstancePool->setDocumentation($this->createNewDocumentationGenerator());
        $isInInstancePool->setName('isInInstancePool');
        $isInInstancePool->addParameter('key', '', 'string');
        $isInInstancePool->addParameter('type', '', 'string');
        //replace with content block
        $isInInstancePool->setBody(array(
            'switch ($type) {',
            '    case \'factory\';',
            '        return (isset($this->factoryInstancePool[$key]));',
            '        break;',
            '    case \'shared\':',
            '        return (isset($this->sharedInstancePool[$key]));',
            '        break;',
            '    default:',
            '        return (isset($this->defaultInstancePool[$key]));',
            '        break;',
            '}'
        ));

        if (isset($this->configuration['parent_class_name'])) {
            $class->addExtends($this->configuration['parent_class_name']);
        }
        $class->setName($this->configuration['class_name']);
        $class->setNamespace($this->configuration['namespace']);
        $class->setDocumentation($documentation);
        $class->addClassProperty($factoryInstancePool);
        $class->addClassProperty($sharedInstancePool);
        $class->addMethod($isInInstancePool);

        //create instance pooling methods
        //create method for shared_instance
        //create method for single_instance

        $content = '<?php' . PHP_EOL . $class->generate();

        if (file_put_contents($this->outputPath . DIRECTORY_SEPARATOR . $this->configuration['file_name'], $content) === false) {
            throw new Exception('can not create new locator in "' . $this->outputPath . DIRECTORY_SEPARATOR . $this->configuration['file_name']);
        }
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

    /**
     * @return DocumentationGenerator
     */
    private function createNewDocumentationGenerator()
    {
        return new DocumentationGenerator($this->indention);
    }
} 