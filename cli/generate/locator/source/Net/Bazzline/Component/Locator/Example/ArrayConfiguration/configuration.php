<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

return array(
    //add classes here
    'extends' => array(
        'BaseLocator'
    ),
    //default for "is_factory" is false
    //default for "is_shared" is true
    'instances' => array(
        array(
            'alias'         => 'ExampleUniqueInvokableInstance',
            'class'         => 'Application\Model\ExampleUniqueInvokableInstance',
            'is_factory'    => false,
            'is_shared'     => false
        ),
        array(
            'alias'         => 'ExampleUniqueFactorizedInstance',
            'class'         => 'Application\Factory\ExampleUniqueFactorizedInstanceFactory',
            'is_factory'    => true,
            'is_shared'     => false
        ),
        array(
            'alias'         => 'ExampleSharedInvokableInstance',
            'class'         => 'Application\Model\ExampleSharedInvokableInstance',
            'is_factory'    => false,
            'is_shared'     => true
        ),
        array(
            'alias'         => 'ExampleSharedFactorizedInstance',
            'class'         => 'Application\Factory\ExampleSharedFactorizedInstanceFactory',
            'is_factory'    => true,
            'is_shared'     => true
        )
    ),
    //add interfaces here
    'implements' => array(),
    'name' => 'Locator',    //determines file name as well as php class name
    'namespace' => 'Application\Service',
    'file_path' => __DIR__,
    //add use statements here
    'uses' => array()
);