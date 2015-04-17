<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-16
 */

class Arguments
{
    /** @var array */
    private $arguments;

    /** @var array */
    private $lists;

    /** @var array */
    private $triggers;

    /** @var array */
    private $values;

    /**
     * @param null|array $argv
     */
    public function __construct($argv = null)
    {
        $this->arguments    = array();
        $this->lists        = array();
        $this->triggers     = array();
        $this->values       = array();

        if (is_array($argv)) {
            $this->setArguments($argv);
        }
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string $name
     * @return null|mixed
     */
    public function getTrigger($name)
    {

    }

    /**
     * @return array
     */
    public function getTriggers()
    {
        return ($this->hasTriggers()) ? $this->triggers : array();
    }

    /**
     * @param string $name
     * @return null|mixed
     */
    public function getValue($name)
    {

    }

    /**
     * @return array
     */
    public function getValues()
    {
        return ($this->hasValues()) ? $this->values : array();
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return ($this->hasLists()) ? $this->lists : array();
    }

    /**
     * @return bool
     */
    public function hasArguments()
    {
        return (!empty($this->arguments));
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasList($name)
    {
        return (isset($this->lists[$name]));
    }

    /**
     * @return bool
     */
    public function hasLists()
    {
        return (!empty($this->lists));
    }

    /**
     * @return bool
     */
    public function hasValues()
    {
        return (!empty($this->values));
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTrigger($name)
    {
        return (isset($this->triggers[$name]));
    }

    /**
     * @return bool
     */
    public function hasTriggers()
    {
        return (!empty($this->triggers));
    }

    public function setArguments(array $argv)
    {
        array_shift($argv);
        $this->arguments = $argv;
        $this->generate($this->arguments);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    private function addToList($name, $value)
    {
        if (isset($this->lists[$name])) {
            $this->lists[$name][] = $value;
        } else {
            $this->lists[$name] = array($value);
        }
    }

    private function generate(array $arguments)
    {
        foreach ($arguments as $argument) {
            if ($this->startsWith($argument, '--')) {
                if ($this->contains($argument, '=')) {
                    $position   = strpos($argument, '=');
                    $name       = substr($argument, 2, ($position - 2));
                    $value      = substr($argument, ($position + 1));
                    $this->addToList($name, $value);
                } else {
                    $this->triggers[] = substr($argument, 2);
                }
            } else if ($this->startsWith($argument, '-')) {
                if (strlen($argument) === 2) {
                    $this->triggers[] = substr($argument, 1);
                } else {
                    $name   = substr($argument, 1, 1);
                    $value  = substr($argument, 2);
                    $this->addToList($name, $value);
                }
            } else {
                $this->values[] = $argument;
            }

        }
    }

    /**
     * @param string $string
     * @param string $search
     * @return bool
     */
    private function contains($string, $search)
    {
        if (strlen($search) == 0) {
            $contains = false;
        } else {
            $contains = !(strpos($string, $search) === false);
        }

        return $contains;
    }

    /**
     * @param string $string
     * @param string $start
     * @return bool
     */
    private function startsWith($string, $start)
    {
        return (strncmp($string, $start, strlen($start)) === 0);
    }
}