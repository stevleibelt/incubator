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
     * @param mixed $data
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($data = null);
} 