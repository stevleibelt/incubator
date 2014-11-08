<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-07 
 */

namespace De\Leibelt\ProcessPipe;

/**
 * Interface ExecutableInterface
 * @package De\Leibelt\ProcessPipeline
 */
interface ExecutableInterface
{
    /**
     * @param mixed $input
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($input = null);
} 