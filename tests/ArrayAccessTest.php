<?php 
class ArrayAccessTest
    extends PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        $models = new Wally_Wordpress_Model_Pages();
        $this->assertInstanceOf("Wally_Wordpress_Model_ArrayAccessAbstract", $models);
        
        $models[] = 1;
        $models[] = 2;
        $models[] = "walter";
        
        $this->assertSame(3, count($models));
        
        $this->assertSame(1, $models[0]);
        $this->assertSame(2, $models[1]);
        $this->assertSame("walter", $models[2]);
    }
    
    public function testIssetUnset()
    {
        $models = new Wally_Wordpress_Model_Pages();
        
        $models["walter"] = "hello";
        
        $this->assertTrue(isset($models["walter"]));
        
        unset($models["walter"]);
        
        $this->assertFalse(isset($models["walter"]));
    }
    
    public function testIterator()
    {
        $models = new Wally_Wordpress_Model_Pages();
        
        $models[] = "walter";
        $models[] = "ciao";
        $models[] = "hello";
        
        $value = $models->current();
        $this->assertEquals("walter", $value);
        
        $models->next();
        $value = $models->current();
        $this->assertEquals("ciao", $value);
        
        $value = $models->key();
        $this->assertSame(1, $value);
        
        $models->rewind();
        
        $this->assertSame(0, $models->key());
    }
    
    /**
     * @expectedException Zend_Exception 
     */
    public function testUnkwonMethod()
    {
        $models = new Wally_Wordpress_Model_Authors();
        $models->thisMethodDoesntExists();
    }
}