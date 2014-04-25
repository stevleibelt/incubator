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
     * @param string $name
     * @param array $types
     * @param string $comment
     */
    public function addParameter($name, $types = array(), $comment = '')
    {
        $parameter = array(
            'comment'   => (string) $comment,
            'name'      => (string) $name,
            'types'     => (array) $types
        );

        $this->addProperty('parameters', $parameter);
    }

    /**
     * @param array $types
     * @param string $comment
     */
    public function setReturn($types, $comment = '')
    {
        $return = array(
            'comment'   => (string) $comment,
            'types'     => (array) $types
        );
        $this->addProperty('return', $return, false);
    }

    /**
     * @param string $exception
     */
    public function addThrows($exception)
    {
        $this->addProperty('throws', (string) $exception);
    }

    /**
     * @param string $toDo
     */
    public function addTodoS($toDo)
    {
        $this->addProperty('todos', (string) $toDo);
    }



    /**
     * @param string $name
     * @param array $types
     */
    public function setVariable($name, $types = array())
    {
        $variable = array(
            'name'  => $name,
            'types' => $types
        );
        $this->addProperty('variable', $variable, false);
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
            $this->generateToDoS(),
            $this->generateParameters(),
            $this->generateReturn(),
            $this->generateThrows(),
            $this->generateVariable(),
            $this->generateLine(' */'),
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
        $package = $this->getProperty('package');

        return (is_string($package)) ? ' * @package ' . $package : '';
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

        foreach ($this->getProperty('parameters', array()) as $parameter) {
            $line = ' * @param';
            if (!empty($parameter['types'])) {
                $line .= ' ' . implode('|', $parameter['types']);
            }
            $line .= ' $' . $parameter['name'];
            if (strlen($parameter['comment']) > 0) {
                $line .= ' ' . $parameter['comment'];
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
        $return = $this->getProperty('return');
        $line = '';

        if (is_array($return)) {
            $line = ' * @return';
            if (!empty($return['types'])) {
                $line .= ' ' . implode('|', $return['types']);
            }
            if (strlen($return['comment']) > 0) {
                $line .= ' ' . $return['comment'];
            }
        }

        return $line;
    }

    /**
     * @return string
     */
    private function generateThrows()
    {
        $exceptions = $this->getProperty('throws', array());
        $line = '';

        if (!empty($exceptions)) {
            $line .= ' * @throws ' . implode('|', $exceptions);
        }

        return $line;
    }

    /**
     * @return array
     */
    private function generateToDoS()
    {
        $toDoS = $this->getProperty('todos', array());
        $array = array();

        foreach ($toDoS as $todo) {
            $array[] = ' * @todo ' . $todo;
        }

        return $array;
    }

    /**
     * @return string
     */
    private function generateVariable()
    {
        $variable = $this->getProperty('variable', array());
        $line = '';

        if (!empty($variable)) {
            $line .= ' * @var';
            if (!empty($variable['types'])) {
                $line .= ' ' . implode('|', $variable['types']);
            }
            $line .= ' ' . $variable['name'];
        }

        return $line;
    }
}