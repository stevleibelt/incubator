<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-12-08
 */
namespace Net\Bazzline\Component\Curl;

use Exception;
use Net\Bazzline\Component\Curl\HeadLine\HeadLineInterface;
use Net\Bazzline\Component\Curl\Option\OptionInterface;
use Net\Bazzline\Component\Curl\ResponseBehaviour\ResponseBehaviourInterface;
use RuntimeException;

class CurlFacade
{
    const METHOD_DELETE = 0;
    const METHOD_GET    = 1;
    const METHOD_PATCH  = 2;
    const METHOD_POST   = 3;
    const METHOD_PUT    = 4;

    /** @var array|ResponseBehaviourInterface[] */
    private $behaviours;

    /** @var string */
    private $data;

    /** @var int */
    private $method;

    /** @var Request */
    private $request;

    /** @var string */
    private $url;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Response
     * @throws Exception|RuntimeException
     */
    public function andFetchTheResponse()
    {
        $behaviours = $this->behaviours;
        $data       = $this->data;
        $method     = $this->method;
        $request    = $this->request;
        $url        = $this->url;

        switch ($method) {
            case self::METHOD_DELETE:
                $response = $request->delete($url);
                break;
            case self::METHOD_GET:
                $response = $request->get($url);
                break;
            case self::METHOD_PATCH:
                $response = $request->patch($url, $data);
                break;
            case self::METHOD_POST:
                $response = $request->post($url, $data);
                break;
            case self::METHOD_PUT:
                $response = $request->put($url, $data);
                break;
            default:
                throw new RuntimeException(
                    'no http method set'
                );
        }

        foreach ($behaviours as $behaviour) {
            $response = $behaviour->behave($response);
        }

        return $response;
    }

    /**
     * @param bool $alsoTheDefaults
     * @return $this
     */
    public function reset($alsoTheDefaults = false)
    {
        $this->request->reset($alsoTheDefaults);

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function onTheUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function withTheData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param HeadLineInterface $line
     * @return $this
     */
    public function withTheHeaderLine(HeadLineInterface $line)
    {
        $this->request->addHeaderLine($line);

        return $this;
    }

    /**
     * @param OptionInterface $option
     * @return $this
     */
    public function withTheOption(OptionInterface $option)
    {
        $this->request->addOption($option);

        return $this;
    }

    /**
     * @param ResponseBehaviourInterface $behaviour
     * @return $this
     */
    public function withTheResponseBehaviour(ResponseBehaviourInterface $behaviour)
    {
        $this->behaviours = $behaviour;

        return $this;
    }

    //@todo better nameing?
    //  callDelete
    /**
     * @return $this
     */
    public function useDelete()
    {
        $this->method = self::METHOD_DELETE;

        return $this;
    }

    /**
     * @return $this
     */
    public function useGet()
    {
        $this->method = self::METHOD_GET;

        return $this;
    }

    /**
     * @return $this
     */
    public function usePatch()
    {
        $this->method = self::METHOD_PATCH;

        return $this;
    }

    /**
     * @return $this
     */
    public function usePost()
    {
        $this->method = self::METHOD_POST;

        return $this;
    }

    /**
     * @return $this
     */
    public function usePut()
    {
        $this->method = self::METHOD_PUT;

        return $this;
    }
}