<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-12-08
 */
namespace Net\Bazzline\Component\Curl\ResponseModifier;

use Net\Bazzline\Component\Curl\Response;

interface ResponseModifierInterface
{
    /**
     * @param Response $response
     * @return Response
     */
    public function modify(Response $response);
}