<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-10
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\StorageInterface;
use RuntimeException;

interface BuilderInterface
{
    /**
     * @return mixed
     * @throws RuntimeException
     */
    public function build();

    /**
     * @return StorageInterface
     */
    public function andGetStorage();
}
