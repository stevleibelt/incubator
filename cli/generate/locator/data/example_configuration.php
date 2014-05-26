<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-27 
 */

return array(
    'class_name' => 'Locator',
    'file_name' => 'Locator.php',
    'file_path' => __DIR__,
    'namespace' => 'Application\Service',
    'parent_class_name' => 'BaseLocator',
    'shared_instance' => array(
        'CookieManager' => 'Application\Cookie\CookieManager',              //invokable instance, CookieManager can be created by using "$cookieManager = new CookieManager()"
        'Database'      => 'Application\Service\Factory\DatabaseFactory'    //a factory takes care of creating the Database, depending on the php doc return annotation, either a class or an interface will be added to the created php doc, the factory has to implement a provided LocatorDependentInterface
    ),
    'single_instance' => array(
        'Lock'      => 'Application\Service\Factory\LockFileFactory',
        'LockAlias' => 'Application\Service\Factory\LockFileFactory'        //the key defines how the "get"-Method will be named
    )
);