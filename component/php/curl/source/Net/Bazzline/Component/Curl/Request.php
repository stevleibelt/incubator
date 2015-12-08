<?php

namespace Net\Bazzline\Component\Curl;

use Net\Bazzline\Component\Curl\HeadLine\HeadLineInterface;
use Net\Bazzline\Component\Curl\Option\OptionInterface;

class Request
{
    //@see: http://developer.sugarcrm.com/2013/08/30/doing-put-and-delete-with-curl-in-php/
    const HTTP_METHOD_DELETE    = 'DELETE';
    const HTTP_METHOD_GET       = 'GET';
    const HTTP_METHOD_PATCH     = 'PATCH';
    const HTTP_METHOD_POST      = 'POST';
    const HTTP_METHOD_PUT       = 'PUT';

    /** @var array */
    private $defaultHeaderLines = array();

    /** @var array */
    private $defaultOptions = array();

    /** @var array */
    private $headerLines = array();

    /** @var array */
    private $options = array();

    /**
     * @param array $defaultHeaderLines
     * @param array $defaultOptions
     */
    public function __construct(array $defaultHeaderLines = array(), array $defaultOptions = array())
    {
        $this->defaultHeaderLines   = $defaultHeaderLines;
        $this->defaultOptions       = $defaultOptions;
    }

    /**
     * @return Request
     */
    public function __clone()
    {
        return new self(
            $this->defaultHeaderLines,
            $this->defaultOptions
        );
    }

    /**
     * @param HeadLineInterface $line
     */
    public function addHeaderLine(HeadLineInterface $line)
    {
        $this->headerLines[] = $line->line();
    }

    /**
     * @param OptionInterface $option
     */
    public function addOption(OptionInterface $option)
    {
        $this->options[$option->identifier()] = $option->value();
    }

    /**
     * @param string $key - CURLOPT_* - see: http://php.net/manual/en/function.curl-setopt.php
     * @param mixed $value
     */
    public function addRawOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * @param string $key - CURLOPT_* - see: http://php.net/manual/en/function.curl-setopt.php
     */
    public function addRawHeaderLine($line)
    {
        $this->headerLines[] = $line;
    }

    /**
     * @param string $url
     * @return Response
     */
    public function get($url)
    {
        return $this->execute(
            $url,
            null,
            self::HTTP_METHOD_GET
        );
    }

    /**
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function post($url, array $data)
    {
        return $this->execute(
            $url,
            $data,
            self::HTTP_METHOD_POST
        );
    }

    /**
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function put($url, array $data)
    {
        return $this->execute(
            $url,
            $data,
            self::HTTP_METHOD_PUT
        );
    }

    /**
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function patch($url, array $data)
    {
        return $this->execute(
            $url,
            $data,
            self::HTTP_METHOD_PATCH
        );
    }

    /**
     * @param string $url
     * @return Response
     */
    public function delete($url)
    {
        return $this->execute(
            $url,
            null,
            self::HTTP_METHOD_DELETE
        );
    }

    /**
     * @see: https://de.wikipedia.org/wiki/Representational_State_Transfer
    public function head($url)
    {
    }
    public function options($url)
    {
    }
    public function trace($url)
    {
    }
    */

    /**
     * @param bool|false $alsoTheDefaults
     */
    public function reset($alsoTheDefaults = false)
    {
        $this->headerLines  = array();
        $this->options      = array();

        if ($alsoTheDefaults) {
            $this->defaultHeaderLines   = array();
            $this->defaultOptions       = array();
        }
    }

    /**
     * @param string $url
     * @param null|array $data
     * @param string $method
     * @return Response
     */
    private function execute($url, $data, $method)
    {
        $headerLines    = array_merge($this->headerLines, $this->defaultHeaderLines);
        $options        = array_merge($this->options, $this->defaultOptions);

        $headerLines[]  = 'X-HTTP-Method-Override: ' . $method; //@see: http://tr.php.net/curl_setopt#109634

        $options[CURLOPT_CUSTOMREQUEST]     = $method;  //@see: http://tr.php.net/curl_setopt#109634
        $options[CURLOPT_HEADER]            = 1;
        $options[CURLOPT_HTTPHEADER]        = $headerLines;
        //@todo needed we want to work with json?
        $options[CURLOPT_POSTFIELDS]        = http_build_query($data); //@see: http://www.lornajane.net/posts/2009/putting-data-fields-with-php-curl
        $options[CURLOPT_RETURNTRANSFER]    = true;

        $handler        = curl_init($url);
        curl_setopt_array($handler, $options);
        $content        = curl_exec($handler);
        $contentType    = curl_getinfo($handler, CURLINFO_CONTENT_TYPE);
        $errorCode      = curl_errno($handler);
        $statusCode     = curl_getinfo($handler, CURLINFO_HTTP_CODE);
        //@todo investigate if needed http://www.ivangabriele.com/php-how-to-use-4-methods-delete-get-post-put-in-a-restful-api-client-using-curl/

        $response       = new Response($content, $contentType, $errorCode, $statusCode);

        return $response;
    }
}