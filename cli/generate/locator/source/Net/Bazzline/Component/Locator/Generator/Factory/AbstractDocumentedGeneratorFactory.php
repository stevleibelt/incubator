<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-20 
 */

namespace Net\Bazzline\Component\Locator\Generator\Factory;

use Net\Bazzline\Component\Locator\Generator\Indention;

/**
 * Class AbstractDocumentedGeneratorFactory
 * @package Net\Bazzline\Component\Locator\Generator\Factory
 */
abstract class AbstractDocumentedGeneratorFactory extends AbstractGeneratorFactory
{
    /**
     * @param Indention $indention
     * @return \Net\Bazzline\Component\Locator\Generator\AbstractDocumentedGenerator
     */
    public function create(Indention $indention)
    {
        return parent::create($indention);
    }
}