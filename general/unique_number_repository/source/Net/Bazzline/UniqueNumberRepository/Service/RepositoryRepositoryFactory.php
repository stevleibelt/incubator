<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-07
 */
namespace Net\Bazzline\UniqueNumberRepository\Service;

class RepositoryRepositoryFactory extends AbstractRepositoryFactory
{
    /**
     * @return string
     */
    protected function getRepositoryName()
    {
        return 'repository';
    }
}