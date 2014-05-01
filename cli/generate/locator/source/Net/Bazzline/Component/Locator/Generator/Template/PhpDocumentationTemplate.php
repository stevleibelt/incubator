<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

use Net\Bazzline\Component\Locator\Generator\InvalidArgumentException;
use Net\Bazzline\Component\Locator\Generator\RuntimeException;

/**
 * Class PhpDocumentationTemplate
 * @package Net\Bazzline\Component\Locator\Generator\Template
 */
class PhpDocumentationTemplate extends AbstractTemplate
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
     */
    public function fillOut()
    {
        $this->addContent('/**');
        $this->fillOutSees();
        $this->fillOutComments();
        $this->fillOutClass();
        $this->fillOutPackage();
        $this->fillOutToDoS();
        $this->fillOutParameters();
        $this->fillOutReturn();
        $this->fillOutThrows();
        $this->fillOutVariable();
        $this->addContent(' */');
    }

    private function fillOutClass()
    {
        $class = $this->getProperty('class');

        if (is_string($class)) {
            $line = $this->getLine(' * Class ' . $class);
            $this->addContent($line);
        }
    }

    private function fillOutPackage()
    {
        $package = $this->getProperty('package');

        if (is_string($package)) {
            $line = $this->getLine(' * @package ' . $package);
            $this->addContent($line);
        }
    }

    private function fillOutComments()
    {
        foreach ($this->getProperty('comments', array()) as $comment) {
            $line = $this->getLine(' * ' . $comment);
            $this->addContent($line);
        }
    }

    private function fillOutParameters()
    {

        foreach ($this->getProperty('parameters', array()) as $parameter) {
            $line = $this->getLine(' * @param');
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

    private function fillOutReturn()
    {
        $return = $this->getProperty('return');

        if (is_array($return)) {
            $line = $this->getLine(' * @return');
            if (!empty($return['type_hints'])) {
                $line->add(implode('|', $return['type_hints']));
            }
            if (strlen($return['comment']) > 0) {
                $line->add($return['comment']);
            }
            $this->addContent($line);
        }
    }

    private function fillOutSees()
    {
        foreach ($this->getProperty('sees', array()) as $see) {
            $line = $this->getLine(' * @see ' . $see);
            $this->addContent($line);
        }
    }

    private function fillOutThrows()
    {
        $throws = $this->getProperty('throws', array());

        if (!empty($throws)) {
            $line = $this->getLine(' * @throws ' . implode('|', $throws));
            $this->addContent($line);
        }
    }

    private function fillOutToDoS()
    {
        foreach ($this->getProperty('todos', array()) as $todo) {
            $line = $this->getLine(' * @todo ' . $todo);
            $this->addContent($line);
        }
    }

    private function fillOutVariable()
    {
        $variable = $this->getProperty('variable');

        if (is_array($variable)) {
            $line =  $this->getLine(' * @var');
            if (!empty($variable['type_hints'])) {
                $line->add(implode('|', $variable['type_hints']));
            }
            $line->add('$' . $variable['name']);
            $this->addContent($line);
        }
    }
}