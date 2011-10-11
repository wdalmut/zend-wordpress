<?php 
class PostsTest
    extends PHPUnit_Framework_TestCase
{
    private $_wp;
    private $_posts;
    
    public function setUp()
    {
        parent::setUp();
    
        $this->_wp = Zend_Registry::get("wp");
        $this->_getPosts();
    }
    
    protected function _getPosts()
    {
        $this->_posts = $this->_wp->getPosts();
    }
    
    public function testGetPosts()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Posts", $this->_posts);
    
        $this->assertGreaterThan(0, count($this->_posts));
    }
    
    public function testEmptyResults()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Post", $this->_posts->findOneByTitle(POST_TITLE));
    
        $this->assertInternalType("array", $this->_posts->findAllByTitle(POST_TITLE));
    
        $this->assertGreaterThan(0, count($this->_posts->findAllByTitle(POST_TITLE)));
    
        $this->assertEquals(1, count($this->_posts->findAllByTitle(POST_TITLE)));
    
        $this->assertInstanceOf("Wally_Wordpress_Model_Post", $this->_posts[0]);
    }
    
    public function testPostExistence()
    {
        $this->assertFalse($this->_posts->findOneByTitle(CREATE_POST_TITLE));
    }
    
    public function testCreatePost()
    {
        $page = new Wally_Wordpress_Model_Post();
        $page->title = CREATE_POST_TITLE;
        $page->category = "1";
        $page->content = CREATE_POST_DESCRIPTION;
    
        $this->_wp->save($page);
    
        $this->_getPosts();
    
        $page = $this->_posts->findOneByTitle(CREATE_POST_TITLE);
    
        $this->assertInstanceOf("Wally_Wordpress_Model_Post", $page);
        $this->assertEquals("1", $page->category);
        $this->assertEquals(CREATE_POST_DESCRIPTION, $page->content);
    }
    
    public function testPostEdit()
    {
        $anotherContent = "Another content...";
        
        $page = $this->_posts->findOneByTitle(CREATE_POST_TITLE);
    
        $page->content = $anotherContent;
    
        $this->_wp->save($page);
    
        $this->_getPosts();
    
        $page = $this->_posts->findOneByTitle(CREATE_POST_TITLE);
        $this->assertEquals($anotherContent, $page->content);
    }
    
    public function testRemovePost()
    {
        $page = $this->_posts->findOneByTitle(CREATE_POST_TITLE);
        $ret = $this->_wp->delete($page);
    
        $this->assertTrue($ret);
    
        $this->_getPosts();
        $page = $this->_posts->findOneByTitle(CREATE_POST_TITLE);
    
        $this->assertFalse($page);
    }
    
    public function testPostCount()
    {
        $posts = $this->_wp->getPosts(2);
        $this->assertEquals(2, count($posts));
    }
    
    /**
     * @expectedException Zend_Exception
     */
    public function testUnknowPostModel()
    {
        $class = new stdClass();
        $class->postid = 135;
        $class->title = "ciao";
        $class->content = "hello";
        
        $this->_wp->save($class);
    }
}