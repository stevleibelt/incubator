<?php

return array(
    'assembler'     => '\Net\Bazzline\Component\Locator\Configuration\Assembler\FromArrayAssembler',
    'class_name'    => 'ApplicationLocator',
    'file_exists_strategy' => '\Net\Bazzline\Component\Locator\FileExistsStrategy\DeleteStrategy',
    'file_path'     => __DIR__ . '/../source/Net/Bazzline/StaticFileGenerator/Application/Service',
    'implements'    => array(
        '\Net\Bazzline\Component\Locator\LocatorInterface'
    ),
    'instances' => array(
        /*
        array(
            'alias'         => 'CliProgressBar',
            'class_name'    => '\Net\Bazzline\Component\Cli\ProgressBar\ProgressBar',
            'is_factory'    => false,
            'is_shared'     => true,
            'return_value'  => '\stdClass'
        ),
        */
    ),
    'method_prefix' => 'get',
    'namespace'     => 'Net\Bazzline\StaticPageGenerator\Application\Service',
);