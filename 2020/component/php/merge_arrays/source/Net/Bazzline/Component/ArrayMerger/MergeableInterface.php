<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-18
 */

namespace Net\Bazzline\Component\ArrayMerger;

interface MergeableInterface
{
    public function merge(array $target, array $source, $preserveNumericKeys = false);
}
