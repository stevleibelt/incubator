<?php

namespace Net\Bazzline\Component\Curl\HeadLine;

class ContentTypeFormUtf8 extends AbstractContentType
{
    /**
     * @return string
     */
    protected function suffix()
    {
        return 'application/x-www-form-urlencoded; charset=UTF-8';
    }
}