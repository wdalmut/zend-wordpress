<?php 
class SortTest extends PHPUnit_Framework_TestCase
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
        $this->_pages->sortByUserIdOrderAsc();

        $this->assertEquals($this->_pages[9]->userId ,  10);
        $this->assertEquals($this->_pages[8]->userId ,  9);
        $this->assertEquals($this->_pages[7]->userId ,  8);
        $this->assertEquals($this->_pages[6]->userId ,  7);
    }
}
