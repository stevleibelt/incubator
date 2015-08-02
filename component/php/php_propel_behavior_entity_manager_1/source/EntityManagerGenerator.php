<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 */
class EntityManagerGenerator
{
    /** @var string */
    private $pathNameForOutput;

    /** @var array */
    private $methodNameToClassName;

    /** @var self */
    private static $instance;

    protected function __construct() {}

    public function __destruct()
    {
        $this->generate($this->pathNameForOutput, $this->methodNameToClassName);
    }

    private function __clone() {}

    private function __wakeup() {}

    /**
     * @return static
     */
    public static function getInstance()
    {
        if(!(self::$instance instanceof EntityManagerGenerator)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param string $databaseName
     * @param string $methodName
     * @param string $fullQualifiedClassName
     * @return $this
     */
    public function add($databaseName, $methodName, $fullQualifiedClassName)
    {
        $key = 'create' . ucfirst($databaseName) . ucfirst($methodName);

        if (isset($this->methodNameToClassName[$key])) {
            throw new InvalidArgumentException(
                'you are trying to add "' . $methodName .
                '" twice for the database "' . $databaseName . '"'
            );
        }

        $this->methodNameToClassName[$key] = $fullQualifiedClassName;

        return $this;
    }

    private function generate($fileName, $methodNamesToClassName)
    {
        $content = '<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since ' . date('Y-m-d') . '
 */

//@todo add optional namespace

class EntityManager
{
//@todo iterate over $methodNameToClassName and create method, maybe use template?
}
';

        $contentCouldBeNotWritten = (file_put_contents($fileName, $content) === false);

        if ($contentCouldBeNotWritten) {
            throw new RuntimeException(
                'could not write content to "' . $fileName . '"'
            );
        }
    }
}