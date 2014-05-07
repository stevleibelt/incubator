<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class DocumentationGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 */
class DocumentationGenerator extends AbstractGenerator
{
    /**
     * @param string $comment
     */
    public function addComment($comment)
    {
        $this->addProperty('comments', (string) $comment, true);
    }

    /**
     * @param string $className
     */
    public function setClass($className)
    {
        $this->addProperty('class', (string) $className, false);
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
     * @param array $typeHints
     * @param string $comment
     */
    public function addParameter($name, $typeHints = array(), $comment = '')
    {
        $parameter = array(
            'comment'       => (string) $comment,
            'name'          => (string) $name,
            'type_hints'    => (array) $typeHints
        );

        $this->addProperty('parameters', $parameter);
    }

    /**
     * @param array $typeHints
     * @param string $comment
     */
    public function setReturn($typeHints, $comment = '')
    {
        $return = array(
            'comment'       => (string) $comment,
            'type_hints'    => (array) $typeHints
        );
        $this->addProperty('return', $return, false);
    }

    /**
     * @param string $see
     */
    public function addSee($see)
    {
        $this->addProperty('sees', (string) $see);
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
     * @param array $typeHints
     */
    public function setVariable($name, $typeHints = array())
    {
        $variable = array(
            'name'          => $name,
            'type_hints'    => $typeHints
        );
        $this->addProperty('variable', $variable, false);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        $this->addContent('/**');
        $this->generateSees();
        $this->generateComments();
        $this->generateClass();
        $this->generatePackage();
        $this->generateToDoS();
        $this->generateParameters();
        $this->generateReturn();
        $this->generateThrows();
        $this->generateVariable();
        $this->addContent(' */');
    }

    private function generateClass()
    {
        $class = $this->getProperty('class');

        if (is_string($class)) {
            $line = $this->getLineGenerator(' * Class ' . $class);
            $this->addContent($line);
        }
    }

    private function generatePackage()
    {
        $package = $this->getProperty('package');

        if (is_string($package)) {
            $line = $this->getLineGenerator(' * @package ' . $package);
            $this->addContent($line);
        }
    }

    private function generateComments()
    {
        foreach ($this->getProperty('comments', array()) as $comment) {
            $line = $this->getLineGenerator(' * ' . $comment);
            $this->addContent($line);
        }
    }

    private function generateParameters()
    {

        foreach ($this->getProperty('parameters', array()) as $parameter) {
            $line = $this->getLineGenerator(' * @param');
            if (!empty($parameter['type_hints'])) {
                $line->add(implode('|', $parameter['type_hints']));
            }
            $line->add('$' . $parameter['name']);
            if (strlen($parameter['comment']) > 0) {
                $line->add($parameter['comment']);
            }
            $this->addContent($line);
        }
    }

    private function generateReturn()
    {
        $return = $this->getProperty('return');

        if (is_array($return)) {
            $line = $this->getLineGenerator(' * @return');
            if (!empty($return['type_hints'])) {
                $line->add(implode('|', $return['type_hints']));
            }
            if (strlen($return['comment']) > 0) {
                $line->add($return['comment']);
            }
            $this->addContent($line);
        }
    }

    private function generateSees()
    {
        foreach ($this->getProperty('sees', array()) as $see) {
            $line = $this->getLineGenerator(' * @see ' . $see);
            $this->addContent($line);
        }
    }

    private function generateThrows()
    {
        $throws = $this->getProperty('throws', array());

        if (!empty($throws)) {
            $line = $this->getLineGenerator(' * @throws ' . implode('|', $throws));
            $this->addContent($line);
        }
    }

    private function generateToDoS()
    {
        foreach ($this->getProperty('todos', array()) as $todo) {
            $line = $this->getLineGenerator(' * @todo ' . $todo);
            $this->addContent($line);
        }
    }

    private function generateVariable()
    {
        $variable = $this->getProperty('variable');

        if (is_array($variable)) {
            $line =  $this->getLineGenerator(' * @var');
            if (!empty($variable['type_hints'])) {
                $line->add(implode('|', $variable['type_hints']));
            }
            $line->add('$' . $variable['name']);
            $this->addContent($line);
        }
    }
}