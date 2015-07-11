<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-05 
 */

namespace Test\Net\Bazzline\Component\Cli\Readline\Configuration;

use Test\Net\Bazzline\Component\Cli\Readline\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @return array
     */
    public function isValidProvider()
    {
        return array(
            'null as data' => array(
                'data'      => null,
                'isValid'   => false
            )
        );
    }

    /**
     * @dataProvider isValidProvider
     * @param $data
     * @param boolean $expectedIsValid
     */
    public function testIsValid($data, $expectedIsValid)
    {
        $validator = $this->getNewValidator();

        $this->assertEquals($expectedIsValid, $validator->isValid($data));
    }
}