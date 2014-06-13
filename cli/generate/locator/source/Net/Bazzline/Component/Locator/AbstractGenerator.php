<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-14 
 */

namespace Net\Bazzline\Component\Locator;

use Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\DocumentationGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\MethodGeneratorFactory;
use Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory;
use Net\Bazzline\Component\Locator\FileExistsStrategy\FileExistsStrategyInterface;

/**
 * Class AbstractGenerator
 * @package Net\Bazzline\Component\Locator
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var BlockGeneratorFactory
     */
    protected $blockGeneratorFactory;

    /**
     * @var ClassGeneratorFactory
     */
    protected $classGeneratorFactory;

    /**
     * @var \Net\Bazzline\Component\Locator\Configuration
     */
    protected $configuration;

    /**
     * @var DocumentationGeneratorFactory
     */
    protected $documentationGeneratorFactory;

    /**
     * @var FileGeneratorFactory
     */
    protected $fileGeneratorFactory;

    /**
     * @var FileExistsStrategyInterface
     */
    protected $fileExistsStrategy;

    /**
     * @var MethodGeneratorFactory
     */
    protected $methodGeneratorFactory;

    /**
     * @var PropertyGeneratorFactory
     */
    protected $propertyGeneratorFactory;

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
    public function setDocumentationGeneratorFactory($documentationFactory)
    {
        $this->documentationGeneratorFactory = $documentationFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\FileGeneratorFactory $fileFactory
     * @return $this
     */
    public function setFileGeneratorFactory($fileFactory)
    {
        $this->fileGeneratorFactory = $fileFactory;

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
    public function setMethodGeneratorFactory($methodFactory)
    {
        $this->methodGeneratorFactory = $methodFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\PropertyGeneratorFactory $propertyFactory
     * @return $this
     */
    public function setPropertyGeneratorFactory($propertyFactory)
    {
        $this->propertyGeneratorFactory = $propertyFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\ClassGeneratorFactory $classFactory
     * @return $this
     */
    public function setClassGeneratorFactory($classFactory)
    {
        $this->classGeneratorFactory = $classFactory;

        return $this;
    }

    /**
     * @param \Net\Bazzline\Component\CodeGenerator\Factory\BlockGeneratorFactory $blockFactory
     * @return $this
     */
    public function setBlockGeneratorFactory($blockFactory)
    {
        $this->blockGeneratorFactory = $blockFactory;

        return $this;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @throws RuntimeException
     */
    protected function moveOldFileIfExists($filePath, $fileName)
    {
        $fullQualifiedFilePath = $filePath . DIRECTORY_SEPARATOR . $fileName;

        if (file_exists($fullQualifiedFilePath)) {
            if ($this->fileExistsStrategy instanceof FileExistsStrategyInterface) {
                $this->fileExistsStrategy
                    ->setFileName($fileName)
                    ->setFilePath($filePath)
                    ->execute();
            } else {
                throw new RuntimeException(
                    'file "' . $fullQualifiedFilePath . '" already exists'
                );
            }
        }
    }
}