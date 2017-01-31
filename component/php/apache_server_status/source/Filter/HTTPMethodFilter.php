<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Filter;

class HTTPMethodFilter extends AbstractFilter
{
    //@see: https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html
    const HTTP_METHOD_CONNECT   = 'CONNECT';
    const HTTP_METHOD_DELETE    = 'DELETE';
    const HTTP_METHOD_GET       = 'GET';
    const HTTP_METHOD_HEAD      = 'HEAD';
    const HTTP_METHOD_OPTIONS   = 'OPTIONS';
    const HTTP_METHOD_POST      = 'POST';
    const HTTP_METHOD_PUT       = 'PUT';
    const HTTP_METHOD_TRACE     = 'TRACE';

    /** @var string */
    private $method;

    /**
     * HTTPMethodFilter constructor.
     *
     * @param string $method
     */
    public function __construct($method)
    {
        $this->method = $method;
    }

    /**
     * @param string $string
     *
     * @return boolean
     */
    public function isSatisfied($string)
    {
        $isSatisfied = false;

        if ($this->startsWith($string, ' <i>')) {
            $method = $this->sliceSection($string, '{', '');

            $isSatisfied = ($method === $this->method);
        }

        return $isSatisfied;
    }
}