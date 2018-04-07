<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-04-06
 */

namespace Net\Bazzline\Component\BatchJob\Model;

use ArrayAccess;
use Traversable;

interface CollectionInterface extends ArrayAccess, Traversable
{
}