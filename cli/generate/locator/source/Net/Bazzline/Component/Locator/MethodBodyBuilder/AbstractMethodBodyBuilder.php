<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-12 
 */

namespace Net\Bazzline\Component\Locator\MethodBodyBuilder;

/**
 * Class AbstractMethodBodyBuilder
 * @package Net\Bazzline\Component\Locator\MethodBodyBuilder
 */
abstract class AbstractMethodBodyBuilder implements MethodBodyBuilderInterface
{
    /**
     * @param array $parameters
     * @throws RuntimeException
     */
    protected function assertMandatoryParameters(array $parameters)
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