<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

return array(
    'controllers' => array(
        'factories' => array(
            'NetBazzlineZfCliGenerator\Controller\Console\Index' => 'NetBazzlineZfCliGenerator\Controller\Console\IndexControllerFactory'
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'locator_generate' => array(
                    'options' => array(
                        'route' => 'net_bazzline cli generate-configuration',
                        'defaults' => array(
                            'controller' => 'NetBazzlineZfCliGenerator\Controller\Console\Generate',
                            'action' => 'configuration'
                        )
                    )
                ),
                'locator_list' => array(
                    'options' => array(
                        'route' => 'net_bazzline cli generate-cli',
                        'defaults' => array(
                            'controller' => 'NetBazzlineZfCliGenerator\Controller\Console\Generate',
                            'action' => 'cli'
                        )
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'NetBazzlineCliGenerator_GenerateCliContent'            => 'NetBazzlineZfCliGenerator\Service\GenerateCliContentFactory',
            'NetBazzlineCliGenerator_GenerateConfigurationContent'  => 'NetBazzlineZfCliGenerator\Service\GenerateConfigurationContentFactory'
        )
    )
);
