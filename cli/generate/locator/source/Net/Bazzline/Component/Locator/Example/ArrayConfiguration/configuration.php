<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

return array(
    //add class names here, depending on entries in use section, full qualified or not
    'extends' => array(
        'BaseLocator'
    ),
    //file path where files will be generated
    'file_path' => __DIR__,
    //format: array(['alias' => <string>], 'name' => <string>, ['is_factory' => <boolean>], ['is_shared' => <boolean>])
    'instances' => array(
        array(
            'alias'         => 'ExampleUniqueInvokableInstance',
            'class'         => 'Application\Model\ExampleUniqueInvokableInstance',
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
        ),
        array(
            'alias'         => 'ExampleSharedFactorizedInstance',
            'class'         => 'Application\Factory\ExampleSharedFactorizedInstanceFactory',
            'is_factory'    => true,
        )
    ),
    //add interface names here, depending on entries in use section, full qualified or not
    'implements' => array(
        'My\Full\QualifiedInterface',
        'MyInterface'
    ),
    'name' => 'Locator',    //determines file name as well as php class name
    'namespace' => 'Application\Service',
    //add use statements here
    //format: array(['alias' => <string>], 'name' => <string>)
    'uses' => array(
        array(
            'alias' => 'MyInterface',
            'name'  => 'My\OtherInterface'
        )
    )
);