<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-03 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Interface IndentionAwareInterface
 * @package Net\Bazzline\Component\Locator\Generator
 */
interface IndentionAwareInterface
{
    /**
     * @return null|Indention
     */
    public function getIndention();

    /**
     * @param Indention $indention
     * @return $this
     */
    public function setIndention(Indention $indention);
} 