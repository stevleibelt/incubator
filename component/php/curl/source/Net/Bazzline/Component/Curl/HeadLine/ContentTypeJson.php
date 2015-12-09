<?php

namespace Net\Bazzline\Component\Curl\HeadLine;

class ContentTypeJson extends AbstractContentType
{
    /**
     * @return string
     */
    protected function suffix()
    {
        return 'application/json';
    }
}
