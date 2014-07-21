<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\Fork;

/**
 * Class AbstractTask
 * @package Net\Bazzline\Component\Fork
 */
abstract class AbstractTask implements ExecutableInterface
{
    /**
     * @var int
     */
    private $parentProcessId;

    /**
     * @param int $parentProcessId
     */
    public function setParentProcessId($parentProcessId)
    {
        $this->parentProcessId = $parentProcessId;
    }

    /**
     * @return int
     */
    public function getParentProcessId()
    {
        return $this->parentProcessId;
    }
}