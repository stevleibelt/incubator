<?php

namespace Net\Bazzline\Component\ArrayMerger;

interface MergeInterface
{
    public function merge(array $toAdd, array $target = array(), $preserveNumericKeys = false);
}
