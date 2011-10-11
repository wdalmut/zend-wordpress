<?php 
class AbstracTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Zend_Exception 
     */
    public function testPropertyNotExists()
    {
        $model = new Wally_Wordpress_Model_Author();
        $this->assertInstanceOf("Wally_Wordpress_Model_Abstract", $model);
        
        $value = $model->notExistsParam;
    }
    
    public function testToArray()
    {
        $model = new Wally_Wordpress_Model_Author();

        $model->helloWorld = "ciao";
        $model->anotherOne = "hello";
        
        $this->assertEquals("ciao", $model->helloWorld);
        $this->assertEquals("hello", $model->anotherOne);
        
        $array = $model->toArray();
        
        $this->assertInternalType("array", $array);
        
        $keys = array_keys($array);
        
        $this->assertEquals('hello_world', $keys[0]);
        $this->assertEquals('another_one', $keys[1]);
        
        $this->assertEquals('ciao', $array['hello_world']);
        $this->assertEquals('hello', $array['another_one']);
    }
}