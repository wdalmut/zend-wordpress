<?php 
class SortTest extends PHPUnit_Framework_TestCase
{
    private $_pages;

    public function setUp()
    {
        parent::setUp();

        $this->_getPages();
    }

    protected function _getPages()
    {
        $this->_pages = new Wally_Wordpress_Model_Pages();
        
        for ($i=1; $i<10; $i++) {
            $page = new Wally_Wordpress_Model_Page();
            $page->userId = $i;
            $this->_pages[] = $page;
        }
    }

    public function testSortNumericAsc()
    {
        $this->_pages->sortByUserIdOrderAsc();

        $this->assertEquals($this->_pages[0]->userId ,  1);
        $this->assertEquals($this->_pages[1]->userId ,  2);
        $this->assertEquals($this->_pages[2]->userId ,  3);
        $this->assertEquals($this->_pages[3]->userId ,  4);
    }

    public function testSortNumericDesc()
    {
        $this->_pages->sortByUserIdOrderDesc();

        $this->assertEquals($this->_pages[0]->userId ,  9);
        $this->assertEquals($this->_pages[1]->userId ,  8);
        $this->assertEquals($this->_pages[2]->userId ,  7);
        $this->assertEquals($this->_pages[3]->userId ,  6);
    }
}
