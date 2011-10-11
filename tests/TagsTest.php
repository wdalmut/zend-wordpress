<?php 
class TagsTest extends PHPUnit_Framework_TestCase
{
    private $_wp;
    private $_tags;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_wp = Zend_Registry::get("wp");
        $this->_tags = $this->_wp->getTags();
    }
    
    public function testGetTags()
    {
        $this->assertGreaterThan(0, count($this->_tags));
    }
    
    public function testInstanceGetTags()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Tags", $this->_tags);
        
        $tag = $this->_tags[0];
        
        $this->assertInstanceOf("Wally_Wordpress_Model_Tag", $tag);
    }
    
    public function testFindOneTag()
    {
        $tag = $this->_tags->findOneByName(TAG_NAME);
        $this->assertInstanceOf("Wally_Wordpress_Model_Tag", $tag);
        
        $this->assertEquals($tag->name, TAG_NAME);
    }
    
    public function testFindAllTags()
    {
        $tags = $this->_tags->findAllByCount(1);
        $this->assertGreaterThan(0, count($tags));
        
        $tags = $this->_tags->findAllGreaterThanCount(1);
        $this->assertGreaterThan(0, count($tags));
        
        $tags = $this->_tags->findAllLessThanCount(100);
        $this->assertGreaterThan(0, count($tags));
    }
    
    public function testEmptyTagResultSet()
    {
        $tag = $this->_tags->findOneByName("13241afsasfsafsafassfsa");
        $this->assertFalse($tag);
    }
}
