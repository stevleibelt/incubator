<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-11-10
 */

return [
    1 => [
        'description'               => 'this is a test',
        //supported values
        //  month|months
        //  day|days
        //  hour|hours
        //  minute|minutes
        //  second|seconds
        'interval_of_repetition'    => '17 days',
        'execute_upfront'           => 'Foo\BarCheckFactory|/my/script',    //either is callable, a script or a class with some implemented interfaces. either returns >0 or throws an exception if something went wrong
        'execute'                   => 'Foo\BarFactory',    //either is callable, a script or a class either returns >0 or throws an exception to tell that something went wrong
        'execute_on_failure'        => 'Foo\ErrorBarHandlerFactory',    //either is a callable, a script or a class with some implemented interfaces (InjectedScheduler).
        //supported values
        //  HH:MM:SS
        //  YYYY-MM-DD HH:MM:SS
        'initial_start_at'          => '12:05'
    ]
];
