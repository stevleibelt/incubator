<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 * @todo make output path configurable
 */
class EntityManagerGenerator
{
    /** @var array */
    private $databaseWithMethodNameToClassName;

    /** @var bool */
    private $generationDone;

    /** @var string */
    private $indention;

    /** @var string */
    private $namespace;

    /** @var string */
    private $pathNameForOutput;

    /** @var self */
    private static $instance;

    protected function __construct()
    {
        $this->generationDone = false;
    }

    public function __destruct()
    {
        if ($this->wasNotAlreadyGenerated()) {
            if (is_null($this->indention)) {
                $this->indention = '   ';
            }
            if (is_null($this->pathNameForOutput)) {
                $this->pathNameForOutput = getcwd() . DIRECTORY_SEPARATOR . 'EntityManager';
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
     * @param string $indention
     */
    public function setIndention($indention)
    {
        $this->indention = $indention;
    }

    /**
     * @param string $path
     */
    public function setPathToOutput($path)
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

        $this->pathNameForOutput = $path . DIRECTORY_SEPARATOR . 'EntityManager';
    }

    /**
     * @param string $databaseName
     * @param string $methodName
     * @param string $fullQualifiedClassName
     * @return $this
     */
    public function add($databaseName, $methodName, $fullQualifiedClassName)
    {
        if (isset($this->databaseWithMethodNameToClassName[$databaseName][$methodName])) {
            throw new InvalidArgumentException(
                'you are trying to add "' . $methodName .
                '" twice for the database "' . $databaseName . '"'
            );
        }

        $this->databaseWithMethodNameToClassName[$databaseName][$methodName] = $fullQualifiedClassName;

        return $this;
    }



    /**
     * @throws RuntimeException
     * @todo make indention configurable
     */
    public function generate()
    {
        $databaseWithMethodNamesToClassName = $this->databaseWithMethodNameToClassName;
        $fileName                           = $this->pathNameForOutput;
        $indention                          = $this->indention;
        $namespace                          = (is_null($this->namespace))
            ? ''
            : 'namespace ' . $this->namespace . PHP_EOL;

        $content = '<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since ' . date('Y-m-d') . '
 */';

$content .= $namespace;
$content .='

class EntityManager
{
    /**
     * @return PDO
     */
    public function getConnection()
    {
        return Propel::getConnection();
    }
';

        //@todo iterate over $databaseWithMethodNameToClassName and create method, maybe use template?
        //@todo add getConnection|getPdo
        foreach ($databaseWithMethodNamesToClassName as $database => $methodNamesToClassName) {
            $methodPrefix = 'create' .ucfirst($database);

            foreach ($methodNamesToClassName as $methodName => $className) {
                $content .= PHP_EOL .
                    $indention . '/**' . PHP_EOL .
                    $indention . ' * @return ' . $className . PHP_EOL .
                    $indention . ' */' . PHP_EOL .
                    $indention . 'public function ' . $methodPrefix .ucfirst($methodName) . '()' . PHP_EOL .
                    $indention . '{' . PHP_EOL .
                    $indention . $indention . 'return new ' . $className . '();' . PHP_EOL .
                    $indention . '}' . PHP_EOL;
            }
        }

        $content .= '}';

echo var_export($content, true) . PHP_EOL;
        $contentCouldBeNotWritten = (file_put_contents($fileName, $content) === false);

        if ($contentCouldBeNotWritten) {
            throw new RuntimeException(
                'could not write content to "' . $fileName . '"'
            );
        }

        $this->generationDone = true;
    }



    /**
     * @return bool
     */
    private function wasNotAlreadyGenerated()
    {
        return $this->generationDone;
    }
}
