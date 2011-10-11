<?php 
class CategoriesTest extends PHPUnit_Framework_TestCase
{
    private $_wp;
    private $_categories;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_wp = Zend_Registry::get("wp");
        $this->_categories = $this->_wp->getCategories();
    }
    
    public function testGetCategories()
    {
        $this->assertGreaterThan(0, count($this->_categories));
    }
    
    public function testInstanceGetCategories()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Categories", $this->_categories);
        
        $category = $this->_categories[0];
        
        $this->assertInstanceOf("Wally_Wordpress_Model_Category", $category);
    }
    
    public function testFindOneCategory()
    {
        $category = $this->_categories->findOneByCategoryName(CATEGORY_NAME);
        $this->assertInstanceOf("Wally_Wordpress_Model_Category", $category);
        
        $this->assertEquals($category->categoryName, CATEGORY_NAME);
    }
    
    public function testEmptyCategoryResultSet()
    {
        $category = $this->_categories->findOneByCategoryName("13241afsasfsafsafassfsa");
        $this->assertFalse($category);
    }
}
