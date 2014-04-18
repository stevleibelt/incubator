<?php

namespace Net\Bazzline\Component\ArrayMerger;

interface MergeableInterface
{
    public function merge(array $target, array $source, $preserveNumericKeys = false);
}
