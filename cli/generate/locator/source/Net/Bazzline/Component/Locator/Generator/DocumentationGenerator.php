<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class DocumentationGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @see http://www.phpdoc.org/docs/latest/index.html
 * @todo implement all tags from phpdoc
 */
class DocumentationGenerator extends AbstractGenerator
{
    /**
     * @var boolean
     */
    private $addEmptyLine;

    /**
     * @param string $comment
     */
    public function addComment($comment)
    {
        $this->addGeneratorProperty('comments', (string) $comment, true);
    }

    /**
     * @param string $className
     */
    public function setClass($className)
    {
        $this->addGeneratorProperty('class', (string) $className, false);
    }

    /**
     * @param string $package
     */
    public function setPackage($package)
    {
        $this->addGeneratorProperty('package', (string) $package, false);
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

        $this->addGeneratorProperty('parameters', $parameter);
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
        $this->addGeneratorProperty('return', $return, false);
    }

    /**
     * @param string $see
     */
    public function addSee($see)
    {
        $this->addGeneratorProperty('sees', (string) $see);
    }

    /**
     * @param string $exception
     */
    public function addThrows($exception)
    {
        $this->addGeneratorProperty('throws', (string) $exception);
    }

    /**
     * @param string $toDo
     */
    public function addTodoS($toDo)
    {
        $this->addGeneratorProperty('todos', (string) $toDo);
    }

    /**
     * @param string $name
     * @param string $email
     * @return $this
     */
    public function setAuthor($name, $email = '')
    {
        $author = array(
            'email' => (string) $email,
            'name'  => (string) $name
        );
        $this->addGeneratorProperty('author', $author, false);

        return $this;
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
        $this->addGeneratorProperty('variable', $variable, false);
    }

    /**
     * @param string $number
     * @param string $description
     * @return $this
     * @see http://www.phpdoc.org/docs/latest/for-users/phpdoc/tags/version.html
     */
    public function setVersion($number, $description = '')
    {
        $version = array(
            'description'   => (string) $description,
            'number'        => (string) $number
        );
        $this->addGeneratorProperty('version', $version, false);

        return $this;
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     * @todo implement exception throwing if mandatory parameter is missing
     */
    public function generate()
    {
        if ($this->canBeGenerated()) {
            $this->addEmptyLine = false;
            $this->resetContent();

            $this->addContent('/**');
            $this->generateSees();
            $this->generateComments();
            $this->generateClass();
            $this->generateToDoS();
            $this->generatePackage();
            $this->generateParameters();
            $this->generateReturn();
            $this->generateThrows();
            $this->generateVariable();
            $this->generateAuthor();
            $this->generateVersion();
            $this->addContent(' */');
        }

        return $this->generateStringFromContent();
    }

    private function generateAuthor()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $author = $this->getGeneratorProperty('author');

        if (is_array($author)) {
            $line = $this->getLineGenerator(' * @author ' . $author['name']);
            if (strlen($author['email']) > 0) {
                $line->add('<' . $author['email'] . '>');
            }
            $this->addContent($line);
        }
    }

    private function generateClass()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $class = $this->getGeneratorProperty('class');

        if (is_string($class)) {
            $line = $this->getLineGenerator(' * Class ' . $class);
            $this->addContent($line);
            $this->addEmptyLine = true;
        }
    }

    private function generatePackage()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $package = $this->getGeneratorProperty('package');

        if (is_string($package)) {
            $line = $this->getLineGenerator(' * @package ' . $package);
            $this->addContent($line);
        }
    }

    private function generateComments()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        foreach ($this->getGeneratorProperty('comments', array()) as $comment) {
            $line = $this->getLineGenerator(' * ' . $comment);
            $this->addContent($line);
        }
    }

    private function generateParameters()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        foreach ($this->getGeneratorProperty('parameters', array()) as $parameter) {
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
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $return = $this->getGeneratorProperty('return');

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
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        foreach ($this->getGeneratorProperty('sees', array()) as $see) {
            $line = $this->getLineGenerator(' * @see ' . $see);
            $this->addContent($line);
        }
    }

    private function generateThrows()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $throws = $this->getGeneratorProperty('throws', array());

        if (!empty($throws)) {
            $line = $this->getLineGenerator(' * @throws ' . implode('|', $throws));
            $this->addContent($line);
        }
    }

    private function generateToDoS()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        foreach ($this->getGeneratorProperty('todos', array()) as $todo) {
            $line = $this->getLineGenerator(' * @todo ' . $todo);
            $this->addContent($line);
        }
    }

    private function generateVariable()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $variable = $this->getGeneratorProperty('variable');

        if (is_array($variable)) {
            $line =  $this->getLineGenerator(' * @var');
            if (!empty($variable['type_hints'])) {
                $line->add(implode('|', $variable['type_hints']));
            }
            $line->add('$' . $variable['name']);
            $this->addContent($line);
        }
    }

    private function generateVersion()
    {
        if ($this->addEmptyLine) {
            $this->addContent(' *');
            $this->addEmptyLine = false;
        }

        $version = $this->getGeneratorProperty('version');

        if (is_array($version)) {
            $line = $this->getLineGenerator(' * @version ' . $version['number']);
            if (strlen($version['description']) > 0) {
                $line->add($version['description']);
            }
            $this->addContent($line);
        }
    }
}