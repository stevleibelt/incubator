<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-08-31
 */
namespace Net\Bazzline\Component\ControlStructure\Loop;

use Net\Bazzline\Component\ControlStructure\Specification\SpecificationInterface;

class WhileLoop
{
    /**
     * @param SpecificationInterface $specification
     * @param callable $do
     * @param mixed $subject
     */
    public function loop(SpecificationInterface $specification, callable $do, $subject)
    {
        //@see: http://php.net/manual/en/control-structures.while.php
        while ($specification->isSatisfied($subject)) {
            $do($subject);
        }
    }
}
