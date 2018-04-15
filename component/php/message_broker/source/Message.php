<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-14
 */

namespace Net\Bazzline\Component\MessageQueue;

interface MessageInterface
{
    public function fromString(sring $data): MessageInterface;
    public function toString(): string;
}