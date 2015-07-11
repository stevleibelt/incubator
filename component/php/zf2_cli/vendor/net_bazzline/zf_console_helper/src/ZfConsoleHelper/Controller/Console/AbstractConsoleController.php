<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-09
 */

namespace ZfConsoleHelper\Controller\Console;

use Exception;
use RuntimeException;
use Zend\Mvc\Controller\AbstractConsoleController as ParentClass;
use Zend\Console\ColorInterface;
use Zend\Console\Request as ConsoleRequest;

class AbstractConsoleController extends ParentClass
{
   /**
     * @var bool
     */
    protected $stopExecution = false;

    /**
     * @param $signal
     */
    public function defaultSignalHandler($signal)
    {
        $this->stopExecution = true;
    }

    /**
     * @param AbstractConsoleController $object
     * @param string $methodName
     */
    protected function attachSignalHandler(AbstractConsoleController $object, $methodName = 'defaultSignalHandler')
    {
        declare(ticks = 10);

        pcntl_signal(SIGHUP,    array($object, $methodName));
        pcntl_signal(SIGINT,    array($object, $methodName));
        pcntl_signal(SIGUSR1,   array($object, $methodName));
        pcntl_signal(SIGUSR2,   array($object, $methodName));
        pcntl_signal(SIGQUIT,   array($object, $methodName));
        pcntl_signal(SIGILL,    array($object, $methodName));
        pcntl_signal(SIGABRT,   array($object, $methodName));
        pcntl_signal(SIGFPE,    array($object, $methodName));
        pcntl_signal(SIGSEGV,   array($object, $methodName));
        pcntl_signal(SIGPIPE,   array($object, $methodName));
        pcntl_signal(SIGALRM,   array($object, $methodName));
        pcntl_signal(SIGCONT,   array($object, $methodName));
        pcntl_signal(SIGTSTP,   array($object, $methodName));
        pcntl_signal(SIGTTIN,   array($object, $methodName));
        pcntl_signal(SIGTTOU,   array($object, $methodName));
    }

    /**
     * @param Exception $exception
     */
    protected function handleException(Exception $exception)
    {
        $console = $this->getConsole();
        $console->setColor(ColorInterface::RED);

        $console->writeLine('');
        $console->writeLine('caught exception ' . get_class($exception));
        $console->writeLine('----------------');
        $console->writeLine('with message: ');
        $console->writeLine('');
        $console->setColor(ColorInterface::RESET);
        $console->writeLine($exception->getMessage());
        $console->setColor(ColorInterface::RED);
        $console->writeLine('----------------');
        $console->writeLine('and trace: ');
        $console->writeLine('');
        $console->setColor(ColorInterface::GRAY);
        $console->writeLine($exception->getTraceAsString());

        $console->setColor(ColorInterface::RESET);
    }

    /**
     * @param array $items
     * @param AbstractConsoleController $object
     * @param string $methodName
     * @param array $arguments
     */
    protected function processItems($items, AbstractConsoleController $object, $methodName, $arguments = array())
    {
        foreach ($items as $item) {
            if ($this->stopExecution) {
                break 1;
            } else {
                $parameters = $arguments;
                array_unshift($parameters, $item);
                call_user_func_array(array($object, $methodName), $parameters);
                pcntl_signal_dispatch();
            }
        }
    }

    /**
     * @param string $name
     * @return null|string
     */
    protected function getParameter($name)
    {
        return $this->getRequest()->getParam($name);
    }

    /**
     * for easy up request usage
     * @return \Zend\Stdlib\RequestInterface|ConsoleRequest
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * @param string $shortName
     * @param string $longName
     * @return bool
     */
    protected function hasBooleanParameter($shortName = '', $longName = '')
    {
        $has = (($shortName !== '') && ($this->hasParameter($shortName))
                || ($longName !== '') && ($this->hasParameter($longName)));

        return $has;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function hasParameter($name)
    {
        return (!is_null($this->getParameter($name)));
    }

    /**
     * @throws RuntimeException
     */
    protected function throwExceptionIfNotCalledInsideAnCliEnvironment()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest){
            throw new RuntimeException(
                'only callable inside console environment'
            );
        }
    }
} 