<?php

namespace Net\Bazzline\Propel\Behavior\EntityManager;

use InvalidArgumentException;
use RuntimeException;

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 */
class EntityManagerGenerator
{
    /** @var string */
    private $className;

    /** @var array */
    private $databaseWithMethodNameToEntity;

    /** @var bool */
    private $generationDone;

    /** @var string */
    private $indention;

    /** @var string */
    private $namespace;

    /** @var string */
    private $pathNameForOutputFile;

    /** @var self */
    private static $instance;

    protected function __construct()
    {
        $this->generationDone = false;
    }

    public function __destruct()
    {
        if ($this->noGenerationWasDone()) {
            if (is_null($this->indention)) {
                $this->indention = '   ';
            }
            if (is_null($this->pathNameForOutputFile)) {
                $this->pathNameForOutputFile = getcwd() . DIRECTORY_SEPARATOR . 'EntityManager.php';
            }

            $this->generate();
        }
    }

    private function __clone() {}

    private function __wakeup() {}

    /**
     * @return EntityManagerGenerator
     */
    public static function getInstance()
    {
        if(!(self::$instance instanceof EntityManagerGenerator)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param string $absolutePathToOutput
     * @param string $className
     * @param string $indention
     * @param string $namespace
     * @throws InvalidArgumentException
     */
    public function configure($absolutePathToOutput, $className, $indention, $namespace)
    {
        $this->setClassName($className);
        $this->setIndention($indention);
        $this->setNamespace($namespace);
        $this->createPathNameToFileOutput($absolutePathToOutput);
    }

    /**
     * @param Entity $entity
     * @return $this
     * @throws InvalidArgumentException
     */
    public function add(Entity $entity)
    {
        //@todo make this step optional|configurable
        $databaseName = implode(
            '',
            array_map(
                function (&$name) {
                    return ucfirst($name);
                },
                explode('_', $entity->databaseName())
            )
        );
        $methodName = $entity->methodName();

        if (isset($this->databaseWithMethodNameToEntity[$databaseName][$methodName])) {
            throw new InvalidArgumentException(
                'you are trying to add "' . $methodName .
                '" twice for the database "' . $databaseName . '"'
            );
        }

        $this->databaseWithMethodNameToEntity[$databaseName][$methodName] = $entity;
        $this->generationDone = false;

        return $this;
    }



    /**
     * @throws RuntimeException
     */
    public function generate()
    {
        $className                          = $this->className;
        $databaseWithMethodNamesToEntity    = $this->databaseWithMethodNameToEntity;
        $fileName                           = $this->pathNameForOutputFile;
        $indention                          = $this->indention;
        $hasNamespace                       = !(is_null($this->namespace));

        $content = '<?php';
        $content .= ($hasNamespace)
            ? str_repeat(PHP_EOL, 2) . 'namespace ' . $this->namespace . PHP_EOL
            : PHP_EOL;
$content .='
/**
 * Class ' . $className . '
 *
 * @author ' . __NAMESPACE__ . __CLASS__ . '
 * @since ' . date('Y-m-d') . '
 * @see http://www.bazzline.net
 */
class ' . $className . '
{
' . $indention . '/**
' . $indention . ' * @return PDO
' . $indention . ' */
' . $indention . 'public function getConnection()
' . $indention . '{
' . (str_repeat($indention, 2)) . 'return Propel::getConnection();
' . $indention . '}
';

        foreach ($databaseWithMethodNamesToEntity as $database => $methodNamesToEntity) {
            foreach ($methodNamesToEntity as $methodName => $entity) {
                /** @var Entity $entity */
                $methodName     = 'create' . ucfirst($entity->methodNamePrefix() . ucfirst($entity->methodName()));
                //@todo maybe use template for method generation
                $content .= PHP_EOL .
                    $indention . '/**' . PHP_EOL .
                    $indention . ' * @return \\' . $entity->fullQualifiedClassName() . PHP_EOL .
                    $indention . ' */' . PHP_EOL .
                    $indention . 'public function ' . $methodName . '()' . PHP_EOL .
                    $indention . '{' . PHP_EOL .
                    $indention . $indention . 'return new \\' . $entity->fullQualifiedClassName() . '();' . PHP_EOL .
                    $indention . '}' . PHP_EOL;
            }
        }

        $content .= '}';

        $contentCouldBeNotWritten = (file_put_contents($fileName, $content) === false);

        if ($contentCouldBeNotWritten) {
            throw new RuntimeException(
                'could not write content to "' . $fileName . '"'
            );
        }

        $this->generationDone = true;
    }


    /**
     * @param string $className
     * @todo implement validation
     */
    private function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @param string $indention
     * @todo implement validation
     */
    private function setIndention($indention)
    {
        $this->indention = $indention;
    }

    /**
     * @param string $namespace
     * @todo implement validation
     */
    private function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @param string $path
     * @throws InvalidArgumentException
     */
    private function createPathNameToFileOutput($path)
    {
        if (!is_dir($path)) {
            throw new InvalidArgumentException(
                'provided path "' . $path . '" is not a directory'
            );
        }

        if (!is_writable($path)) {
            throw new InvalidArgumentException(
                'provided path "' . $path . '" is not writable'
            );
        }

        $this->pathNameForOutputFile = $path . DIRECTORY_SEPARATOR . $this->className . '.php';
    }

    /**
     * @return bool
     */
    private function noGenerationWasDone()
    {
        return (!$this->generationDone);
    }
}
