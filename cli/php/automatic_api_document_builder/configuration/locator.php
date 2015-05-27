<?php

return array(
    'assembler' => '\Net\Bazzline\Component\Locator\Configuration\Assembler\FromArrayAssembler',
    //'bootstrap_file' => __DIR__ . '/boostrap.php',
    'class_name' => 'ApplicationLocator',    //determines file name as well as php class name
    //'create_interface' => true, //create interface for locator generator
    //add class name here, depending on entries in use section, full qualified or not
    //'extends' => 'BaseLocator',
    'file_exists_strategy' => '\Net\Bazzline\Component\Locator\FileExistsStrategy\SuffixWithCurrentTimestampStrategy',
    //file path where files will be generated
    'file_path' => __DIR__ . '/../source/Net/Bazzline/Component/ApiDocumentBuilder/Service',
    //format: array(['alias' => <string>], 'name' => <string>, ['is_factory' => <boolean>], ['is_shared' => <boolean>], ['method_body_builder'] => <string>)
    'instances' => array(
        array(
            'alias'         => 'CreateDirectory',
            'class_name'    => '\Net\Bazzline\Component\CommandCollection\Filesystem\Create',
            'is_factory'    => false,
            'is_shared'     => true,
            'return_value'  => '\Net\Bazzline\Component\CommandCollection\Filesystem\Create'
        )
    ),
    //add interface names here, depending on entries in use section, full qualified or not
    //'implements' => array(),
    //prefix for the instance fetching
    'method_prefix' => 'get',
    'namespace' => 'Net\Bazzline\Component\ApiDocumentBuilder\Service',
    //add use statements here
    //format: array(['alias' => <string>], 'class_name' => <string>)
    //'uses' => array()
);