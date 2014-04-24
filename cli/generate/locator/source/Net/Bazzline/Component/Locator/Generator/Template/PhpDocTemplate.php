<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

/**
 * Class PhpDocTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class PhpDocTemplate extends AbstractTemplate
{
    /**
     * @param string $comment
     */
    public function addComment($comment)
    {
        $this->addProperty('comments', (string) $comment, true);
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->addProperty('class', (string) $class, false);
    }

    /**
     * @param string $package
     */
    public function setPackage($package)
    {
        $this->addProperty('package', (string) $package, false);
    }

    /**
     * @param string $parameter
     */
    public function addParameter($parameter)
    {
        $this->addProperty('parameters', (string) $parameter);
    }

    /**
     * @param string $return
     */
    public function setReturn($return)
    {
        $this->addProperty('return', (string) $return, false);
    }

    /**
     * @param string $throws
     */
    public function addThrows($throws)
    {
        $this->addProperty('throws', (string) $throws);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     */
    public function generate()
    {
        $this->generatedContent = array(
            $this->generateLine('/**'),
            $this->generateComments(),
            $this->generateClass(),
            $this->generatePackage(),
            $this->generateParameters(),
            $this->generateReturn(),
            $this->generateThrows(),
            $this->generateLine('*/'),
        );
        $this->clearProperties();
    }

    /**
     * @return string
     */
    private function generateClass()
    {
        $class = $this->getProperty('class');

        return (is_string($class)) ? ' * Class ' . $class : '';
    }

    /**
     * @return string
     */
    private function generatePackage()
    {
        $class = $this->getProperty('package');

        return (is_string($class)) ? ' * @package ' . $class : '';
    }

    /**
     * @return array
     */
    private function generateComments()
    {
        $comments = $this->getProperty('comments', array());
        $array = array();

        foreach ($comments as $comment) {
            $array[] = ' * ' . $comment;
        }

        return $array;
    }

    /**
     * @return array
     */
    private function generateParameters()
    {
        $array = array();

        foreach ($this->getProperty('parameters', array()) as $property) {
            $line = ' * @param ';
            if (!empty($property['types'])) {
                $line .= ' ' . implode('|', $property['types']);
            }
            $line .= ' \$' . $property['name'];
            if (strlen($property['comment']) > 0) {
                $line .= ' ' . $property['comment'];
            }
            $array[] = $this->generateLine($line);
        }

        return $array;
    }

    /**
     * @return string
     */
    private function generateReturn()
    {
        $property = $this->getProperty('return');
        $line = '';

        if (is_array($property)) {
            $line = ' * @return ';
            if (!empty($property['types'])) {
                $line .= ' ' . implode('|', $property['types']);
            }
            if (strlen($property['comment']) > 0) {
                $line .= ' ' . $property['comment'];
            }
        }

        return $line;
    }

    /**
     * @return string
     */
    private function generateThrows()
    {
        $property = $this->getProperty('throws', array());
        $line = '';

        if (!empty($property)) {
            $line .= ' * @throws ' . implode('|', $property);
        }

        return $line;
    }
}