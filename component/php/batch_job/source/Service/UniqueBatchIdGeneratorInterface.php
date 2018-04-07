<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\Batchjob\Service;

interface UniqueBatchIdGeneratorInterface
{
    public function generate() : string;
}