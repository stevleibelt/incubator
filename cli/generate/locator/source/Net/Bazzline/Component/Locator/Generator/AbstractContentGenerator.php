<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-26 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class AbstractContentGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator
 */
abstract class AbstractContentGenerator extends AbstractGenerator
{
    public function __clone()
    {
        $this->clear();
    }

    /**
     * @param Indention $indention
     * @param string|array|GeneratorInterface $content
     * @throws InvalidArgumentException
     */
    public function __construct(Indention $indention, $content = null)
    {
        parent::__construct($indention);
        if (!is_null($content)) {
            $this->add($content);
        }
    }

    /**
     * @param string|array|GeneratorInterface $content
     * @throws InvalidArgumentException
     */
    abstract public function add($content);

    /**
     * @return bool
     */
    abstract public function hasContent();
}