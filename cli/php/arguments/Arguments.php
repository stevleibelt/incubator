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
    private $flags;

    /** @var array */
    private $lists;

    /** @var array */
    private $values;

    /**
     * @param null|array $argv
     */
    public function __construct($argv = null)
    {
        if (is_array($argv)) {
            $this->setArguments($argv);
        } else {
            $this->initiate();
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
     * @return array
     */
    public function getFlags()
    {
        return ($this->hasFlags()) ? $this->flags : array();
    }

    /**
     * @param string $name
     * @return null|mixed
     */
    public function getList($name)
    {
        return ($this->hasList($name)) ? $this->lists[$name] : null;
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return ($this->hasLists()) ? $this->lists : array();
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return ($this->hasValues()) ? $this->values : array();
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
    public function hasFlag($name)
    {
        return in_array($name, $this->flags);
    }

    /**
     * @return bool
     */
    public function hasFlags()
    {
        return (!empty($this->flags));
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

    public function setArguments(array $argv)
    {
        array_shift($argv);
        $this->initiate();
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
        $value = trim($value, '"'); //remove >"< if exists
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
                } else if ($this->contains($argument, '"')) {
                    $position   = strpos($argument, '"');
                    $name       = substr($argument, 2, ($position - 2));
                    $value      = substr($argument, ($position + 1));
                    $this->addToList($name, $value);
                } else {
                    $this->flags[] = substr($argument, 2);
                }
            } else if ($this->startsWith($argument, '-')) {
                if (strlen($argument) === 2) {
                    $this->flags[] = substr($argument, 1);
                } else {
                    $name = substr($argument, 1, 1);
                    if ($this->contains($argument, '=')) {
                        $position = strpos($argument, '=') + 1;
                    } else {
                        $position = 2;
                    }
                    $value = substr($argument, $position);
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

    private function initiate()
    {
        $this->arguments    = array();
        $this->flags        = array();
        $this->lists        = array();
        $this->values       = array();
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