<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-30
 */
namespace Net\Bazzline\Component\ApacheServerStatus\ServerStatus;

class Server
{
    /** @var string */
    private $built;

    /** @var string */
    private $mpm;

    /** @var string */
    private $version;

    /**
     * Server constructor.
     *
     * @param string $built
     * @param string $mpm
     * @param string $version
     */
    public function __construct($built, $mpm, $version)
    {
        $this->built    = $built;
        $this->mpm      = $mpm;
        $this->version  = $version;
    }

    /**
     * @return string - e.g."Oct 06 1983 20:44:43"
     */
    public function getBuilt()
    {
        return $this->built;
    }

    /**
     * @return string - e.g. "prefork"
     */
    public function getMPM()
    {
        return $this->mpm;
    }

    /**
     * @return string - e.g. "Apache/2.4.10 (Debian)"
     */
    public function getVersion()
    {
        return $this->version;
    }
}