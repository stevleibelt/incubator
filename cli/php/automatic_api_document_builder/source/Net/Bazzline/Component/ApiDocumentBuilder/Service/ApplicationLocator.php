<?php
/**
 * @author Net\Bazzline\Component\Locator
 * @since 2015-05-27
 */

namespace Net\Bazzline\Component\ApiDocumentBuilder\Service;

/**
 * Class ApplicationLocator
 *
 * @package Net\Bazzline\Component\ApiDocumentBuilder\Service
 */
class ApplicationLocator
{
    /**
     * @var $sharedInstancePool
     */
    private $sharedInstancePool = array();

    /**
     * @return \Net\Bazzline\Component\CommandCollection\Filesystem\Create
     */
    public function getCreateDirectory()
    {
        return $this->fetchFromSharedInstancePool('\Net\Bazzline\Component\CommandCollection\Filesystem\Create');
    }

    /**
     * @param string $className
     * @return object
     * @throws InvalidArgumentException
     */
    final protected function fetchFromSharedInstancePool($className)
    {
        if ($this->isNotInFactoryInstancePool($className)) {
            if (!class_exists($className)) {
                throw new InvalidArgumentException(
                    'class "' . $className . '" does not exist'
                );
            }
            
            $instance = new $className();
            $this->addToFactoryInstancePool($className, $instance);
        }

        return $this->getFromSharedInstancePool($className);
    }

    /**
     * @param string $className
     * @param object $instance
     * @return $this
     */
    private function addToSharedInstancePool($className, $instance)
    {
        $this->sharedInstancePool[$className] = $instance;

        return $this;
    }

    /**
     * @param string $className
     * @return null|object
     */
    private function getFromSharedInstancePool($className)
    {
        return $this->sharedInstancePool[$className];
    }

    /**
     * @param string $className
     * @return boolean
     */
    private function isNotInSharedInstancePool($className)
    {
        return (!isset($this->sharedInstancePool[$className]));
    }
}