<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-07
 */
namespace Net\Bazzline\UniqueNumberRepository\Service;

use Net\Bazzline\Component\Database\FileStorage\Repository;
use Net\Bazzline\Component\Locator\FactoryInterface;
use Net\Bazzline\Component\Locator\LocatorInterface;

class RepositoryRepositoryFactory implements FactoryInterface
{
    /** @var ApplicationLocator */
    private $locator;

    /**
     * @param LocatorInterface $locator
     * @return $this
     */
    public function setLocator(LocatorInterface $locator)
    {
        $this->locator = $locator;

        return $this;
    }

    /**
     * @return mixed|Repository
     */
    public function create()
    {
        $locator    = $this->locator;

        $factory = $locator->getRepositoryFactory();

        $repository = $factory->create();
        $repository->injectPath('data/repository');

        return $repository;
    }
}