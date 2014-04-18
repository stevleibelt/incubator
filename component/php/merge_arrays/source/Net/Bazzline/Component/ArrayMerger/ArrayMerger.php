<?php

namespace Net\Bazzline\Component\ArrayMerger;

class ArrayMerger implements MergeableInterface
{
    public function merge(array $target, array $source, $preserveNumericKeys = false)
    {
        if (empty($target)) {
            $target = $source;
        } else {
            //taken from (140418): namespace Zend\Stdlib\ArrayUtils::merge(array $a, array $b, $preserveNumericKeys = false)
            foreach ($source as $key => $value) {
                if (array_key_exists($key, $target)) {
                    if (is_int($key) && !$preserveNumericKeys) {
                        $target[] = $value;
                    } elseif (is_array($value) && is_array($target[$key])) {
                        $target[$key] = $this->merge($target[$key], $value, $preserveNumericKeys);
                    } else {
                        $target[$key] = $value;
                    }
                } else {
                    $target[$key] = $value;
                }
            }
        }

        return $target;
    }
}
