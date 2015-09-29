<?php
namespace Phoenix\EloquentMeta\Test;

use Phoenix\EloquentMeta\Helpers;

class HelpersTest extends \PHPUnit_Framework_TestCase
{
    public function testMaybeDecode()
    {
        $data = ['a' => 'A', 'true' => true];
        $validJson = json_encode($data);
        $actual = Helpers::maybeDecode($validJson);
        $this->assertEquals(json_decode($validJson, false), $actual, 'failed to decode a valid json string');

        $invalidJson = '{a: }';
        $actual = Helpers::maybeDecode($invalidJson);
        $this->assertEquals('{a: }', $actual, 'failed to return invalid json');

        $almostJson = '01.01.1970';
        $actual = Helpers::maybeDecode($almostJson);
        $this->assertEquals('01.01.1970', $actual, 'failed to return almost json');
    }
}
