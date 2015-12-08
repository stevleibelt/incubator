<?php

namespace Net\Bazzline\Component\Curl;

class Request
{
    //@see: http://developer.sugarcrm.com/2013/08/30/doing-put-and-delete-with-curl-in-php/
    constant HTTP_METHOD_DELETE = 'DELETE';
    constant HTTP_METHOD_GET    = 'GET';
    constant HTTP_METHOD_PATCH  = 'PATCH';
    constant HTTP_METHOD_POST   = 'POST';
    constant HTTP_METHOD_PUT    = 'PUT';
    /** @var array */
    private $headerLines = array();

    /** @var array */
    private $options = array();

    /**
     * @param string $key - CURLOPT_* - see: http://php.net/manual/en/function.curl-setopt.php
     * @param mixed $value
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * @param string $key - CURLOPT_* - see: http://php.net/manual/en/function.curl-setopt.php
     */
    public function addHeaderLine($line)
    {
        $this->headerLines[] = $line;
    }

    /**
     * @param int $seconds
     */
    public function setTimeout($seconds)
    {
        $this->options[CURLOPT_TIMEOUT] = (int) $seconds;
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
            self::HTTP_METHOD_GET,
            $this->headerLines,
            $this->options
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
            self::HTTP_METHOD_POST,
            $this->headerLines,
            $this->options
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
            self::HTTP_METHOD_PUT,
            $this->headerLines,
            $this->options
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
            self::HTTP_METHOD_PATCH,
            $this->headerLines,
            $this->options
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
            self::HTTP_METHOD_DELETE,
            $this->headerLines,
            $this->options
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

    public function reset()
    {
        $this->headerLines  = array();
        $this->options      = array();
    }

    /**
     * @param string $url
     * @param null|array $data
     * @param string $method
     * @param array $headerLines
     * @param array $options
     * @return Response
     */
    private function execute($url, $data, $method, array $headerLines, array $options)
    {
        $headerLines[]  = 'X-HTTP-Method-Override: ' . $method; //@see: http://tr.php.net/curl_setopt#109634

        $options[CURLOPT_CUSTOMREQUEST]     = $method;  //@see: http://tr.php.net/curl_setopt#109634
        $options[CURLOPT_HEADER]            = 1;
        $options[CURLOPT_HTTPHEADER]        = $headerLines;
        //@todo needed we want to work with json?
        $options[CURLOPT_POSTFIELDS]        = http_build_query($data)); //@see: http://www.lornajane.net/posts/2009/putting-data-fields-with-php-curl
        $options[CURLOPT_RETURNTRANSFER)    = true;

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