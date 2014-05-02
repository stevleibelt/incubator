<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-02 
 */

namespace Net\Bazzline\Component\Locator\Generator\Content;

/**
 * Class Indention
 * @package Net\Bazzline\Component\Locator\Generator\Content
 */
class Indention
{
    /**
     * @var int
     */
    private $level = 0;

    /**
     * @var string
     */
    private $string = '    ';

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @param string $indention
     * @return $this
     */
    public function setString($indention)
    {
        $this->string = (string) $indention;

        return $this;
    }

    /**
     * @param int $number
     * @return $this
     */
    public function decreaseLevel($number = 1)
    {
        $this->level = (($this->level - $number) < 0) ? 0 : ($this->level - $number);

        return $this;
    }

    /**
     * @param int $number
     * @return $this
     */
    public function increaseLevel($number = 1)
    {
        $this->level += $number;

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (str_repeat($this->string, $this->level));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
} 