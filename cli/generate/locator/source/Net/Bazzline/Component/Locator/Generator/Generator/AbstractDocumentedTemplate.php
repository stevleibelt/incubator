<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-02 
 */

namespace Net\Bazzline\Component\Locator\Generator\Template;

/**
 * Class AbstractDocumentedTemplate
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @author stev leibelt <artodeto@bazzline.net>
 */
abstract class AbstractDocumentedTemplate extends AbstractGenerator
{
    /** @var bool */
    protected $completePhpDocumentationAutomatically = false;

    /**
     * @return null|PhpDocumentationTemplate
     */
    public function getDocumentation()
    {
        return $this->getProperty('documentation');
    }

    /**
     * @param PhpDocumentationTemplate $phpDocumentation
     * @param bool $completeAutomatically
     */
    public function setDocumentation(PhpDocumentationTemplate $phpDocumentation, $completeAutomatically = true)
    {
        $this->addProperty('documentation', $phpDocumentation, false);
        $this->completePhpDocumentationAutomatically = $completeAutomatically;
    }
}