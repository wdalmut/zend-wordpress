<?php 
class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testEasy()
    {
        $this->assertEquals("a", "a");
    }
}