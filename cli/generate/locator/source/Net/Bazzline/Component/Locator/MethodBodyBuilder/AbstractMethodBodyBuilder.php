<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-12 
 */

namespace Net\Bazzline\Component\Locator\MethodBodyBuilder;

use Net\Bazzline\Component\CodeGenerator\DocumentationGenerator;
use Net\Bazzline\Component\Locator\Configuration\Instance;

/**
 * Class AbstractMethodBodyBuilder
 * @package Net\Bazzline\Component\Locator\MethodBodyBuilder
 */
abstract class AbstractMethodBodyBuilder implements MethodBodyBuilderInterface
{
    /**
     * @var Instance
     */
    protected $instance;

    public function __clone()
    {
        $this->instance = null;
    }

    /**
     * @param Instance $instance
     * @return $this
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * @param DocumentationGenerator $documentation
     * @return DocumentationGenerator
     */
    public function extend(DocumentationGenerator $documentation)
    {
        return $documentation;
    }

    /**
     * @param array $parameters
     * @throws RuntimeException
     */
    protected function assertMandatoryParameters(array $parameters = array('instance'))
    {
        foreach ($parameters as $parameter) {
            if (!isset($this->$parameter)
                || (is_null($this->$parameter))) {
                throw new RuntimeException(
                    'parameter "' . $parameter . '" is mandatory'
                );
            }
        }
    }
}