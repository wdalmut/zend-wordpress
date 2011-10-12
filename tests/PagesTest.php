<?php
class PagesTest extends PHPUnit_Framework_TestCase
{
    private $_wp;
    private $_pages;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_wp = Zend_Registry::get("wp");
        $this->_getPages();
    }
    
    protected function _getPages()
    {
        $this->_pages = $this->_wp->getPages();
    }
    
    public function testGetPages()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Pages", $this->_pages);
        
        $this->assertGreaterThan(0, count($this->_pages));
    }
    
    public function testEmptyResults()
    {
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $this->_pages->findOneByTitle(PAGE_TITLE));
        
        $this->assertInstanceOf("Wally_Wordpress_Model_Pages", $this->_pages->findAllByTitle(PAGE_TITLE));
        
        $this->assertGreaterThan(0, count($this->_pages->findAllByTitle(PAGE_TITLE)));
        
        $this->assertEquals(1, count($this->_pages->findAllByTitle(PAGE_TITLE)));
        
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $this->_pages[0]);
    }
    
    public function testPageExistence()
    {
        $this->assertFalse($this->_pages->findOneByTitle(CREATE_PAGE_TITLE));
    }
    
    public function testCreatePageThan()
    {
        $page = new Wally_Wordpress_Model_Page();
        $page->title = CREATE_PAGE_TITLE;
        $page->pageStatus = Wally_Wordpress::DRAFT;
    	$page->description = CREATE_PAGE_DESCRIPTION;
    	$page->mtAllowComments = 0;
    	$page->mtAllowPings = 0;
        
        $this->_wp->save($page);
        
        $this->_getPages();
        
        $page = $this->_pages->findOneByTitle(CREATE_PAGE_TITLE);
        
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $page);
        $this->assertEquals(Wally_Wordpress::DRAFT, $page->pageStatus);
        $this->assertEquals(CREATE_PAGE_DESCRIPTION, $page->description);
        $this->assertEquals(0, $page->mtAllowComments);
        $this->assertEquals(0, $page->mtAllowPings);
        
        $page = $this->_pages->findOneGreaterThanPageId(1);
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $page);
        
        $page = $this->_pages->findOneLessThanPageId(10000000);
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $page);
        
    }
    
    public function testPageEdit()
    {
        $page = $this->_pages->findOneByTitle(PAGE_TITLE);
        
        $page->pageStatus = Wally_Wordpress::PUBLISH;
        
        $this->_wp->save($page);
        
        $this->_getPages();
        
        $page = $this->_pages->findOneByTitle(PAGE_TITLE);
        $this->assertEquals(Wally_Wordpress::PUBLISH, $page->pageStatus);
    }
    
    public function testRemovePage()
    {
        $page = $this->_pages->findOneByTitle(CREATE_PAGE_TITLE);
        $ret = $this->_wp->delete($page);
        
        $this->assertTrue($ret);
        
        $this->_getPages();
        $page = $this->_pages->findOneByTitle(CREATE_PAGE_TITLE);
        
        $this->assertFalse($page);        
    }
    
    public function testPageDates()
    {
        $page = $this->_pages->findOneByTitle(PAGE_TITLE);
        $this->assertInstanceOf("Zend_Date", $page->dateCreated);
        $this->assertInstanceOf("Zend_Date", $page->dateCreatedGmt);
        
        $pages = $this->_pages->findAllByDateCreated($page->dateCreated);
        $this->assertGreaterThan(0, count($pages));
        
        $page = $this->_pages->findOneLessThanDateCreated(Zend_Date::now());
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $page);
        
        $page = $this->_pages->findOneByDateCreated($page->dateCreated);
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $page);
        
        $page = $this->_pages->findOneGreaterThanDateCreated($page->dateCreated->subDay(1));
        $this->assertInstanceOf("Wally_Wordpress_Model_Page", $page);
        
    }
    
    /**
     * @expectedException Zend_Date_Exception 
     */
    public function testPageExceptionDates()
    {
        $pages = $this->_pages->findAllByDateCreated('2011-01-01 08:00:00');
    }
}
