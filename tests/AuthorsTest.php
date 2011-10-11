<?php 
class AuthorsTest extends PHPUnit_Framework_TestCase
{
    private $_wp;
    private $_authors;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_wp = Zend_Registry::get("wp");
        $this->_authors = $this->_wp->getAuthors();
    }
    
    public function testGetAuthors()
    {
        $this->assertGreaterThan(0, count($this->_authors));
    }
    
    public function testInstanceGetAuthors()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Authors", $this->_authors);
        
        $author = $this->_authors[0];
        
        $this->assertInstanceOf("Wally_Wordpress_Model_Author", $author);
    }
    
    public function testFindOneAuthor()
    {
        $author = $this->_authors->findOneByUserId(USER_ID);
        $this->assertInstanceOf("Wally_Wordpress_Model_Author", $author);
        
        $this->assertEquals($author->userId, USER_ID);
    }
    
    public function testFindAllAuthors()
    {
        $authors = $this->_authors->findAllByUserId(USER_ID);
        $this->assertGreaterThan(0, count($authors));
        
        $authors = $this->_authors->findAllGreaterThanUserId(0);
        $this->assertGreaterThan(0, count($authors));
        
        $authors = $this->_authors->findAllLessThanUserId(100);
        $this->assertGreaterThan(0, count($authors));
    }
    
    public function testEmptyAuthorResultSet()
    {
        $author = $this->_authors->findOneByUserId("asf"); //Must a number
        $this->assertFalse($author);
    }
    
    public function testUsersBlogs()
    {
        $blogs = $this->_wp->getUsersBlogs();
        
        $blog = $blogs->findOneByIsAdmin(1);
        
        $this->assertEquals(1, $blog->blogid);
    }
}
