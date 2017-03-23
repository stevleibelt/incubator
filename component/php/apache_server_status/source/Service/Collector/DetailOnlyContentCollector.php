<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatus\Service\Collector;

class DetailOnlyContentCollector extends FullContentCollector
{
    /**
     * @param string $line
     */
    public function addInformation($line) {}

    /**
     * @param string $line
     */
    public function addScoreboard($line) {}

    /**
     * @param string $line
     */
    public function addStatistic($line) {}
}