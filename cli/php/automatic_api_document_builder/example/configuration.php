<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-24 
 */

return array(
    'builder' => 'apigen',
    'paths' => array(
        'data'      => __DIR__ . '/data',
        'target'    => __DIR__ . '/output'
    ),
    'projects' => array(
        array(
            'destination'   => 'document/',
            'source'        => 'source/Net/Bazzline/Component/Command/',
            'title'         => 'Command by Bazzline',
            'url'           => 'https://github.com/bazzline/php_component_command'
        )
    ),
    'title' => 'code.bazzline.net'
);