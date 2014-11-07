<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-11-07 
 */

namespace De\Leibelt\ProcessPipe;

/**
 * Class ProcessPipe
 * @package De\Leibelt\ProcessPipeline
 */
class Pipe implements PipeInterface
{
    /** @var array|ExecutableInterface[] */
    private $processes;

    /**
     * @param ExecutableInterface $process
     * [@param ExecutableInterface $process]
     */
    public function __construct()
    {
        $this->processes = array();

        if (func_num_args() > 0) {
            foreach (func_get_args() as $argument) {
                if ($argument instanceof ExecutableInterface) {
                    $this->pipe($argument);
                }
            }
        }
    }

    /**
     * @param mixed $data
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($data = null)
    {
        foreach ($this->processes as $process) {
            $data = $process->execute($data);
        }

        return $data;
    }

    /**
     * @param ExecutableInterface $process
     * @return $this
     */
    public function pipe(ExecutableInterface $process)
    {
        $this->processes[] = $process;

        return $this;
    }
}