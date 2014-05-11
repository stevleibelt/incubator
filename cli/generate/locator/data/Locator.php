<?php
namespace Application\Service;


class Locator extends BaseLocator
{

    private $factoryInstancePool = array();


    private $sharedInstancePool = array();


    function isInInstancePool($key $type)
    {
        switch ($type) {
            case 'factory';
                return (isset($this->factoryInstancePool[$key]));
                break;
            case 'shared':
                return (isset($this->sharedInstancePool[$key]));
                break;
            default:
                return (isset($this->defaultInstancePool[$key]));
                break;
        }
    }

}
