<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-05-02 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class AbstractDocumentedGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @author stev leibelt <artodeto@bazzline.net>
 */
abstract class AbstractDocumentedGenerator extends AbstractGenerator
{
    /** @var bool */
    protected $completeDocumentationAutomatically = false;

    /**
     * @return null|DocumentationGenerator
     */
    public function getDocumentation()
    {
        return $this->getProperty('documentation');
    }

    /**
     * @param DocumentationGenerator $documentation
     * @param bool $completeAutomatically
     */
    public function setDocumentation(DocumentationGenerator $documentation, $completeAutomatically = true)
    {
        $this->addProperty('documentation', $documentation, false);
        $this->completeDocumentationAutomatically = $completeAutomatically;
    }
}