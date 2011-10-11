<?php 
class ConnectionTest extends PHPUnit_Framework_TestCase
{
    public function testBaseConnection()
    {
        $wp = new Wally_Wordpress("http://www.walterdalmut.com", "walter", "wa1t3r83");
        $this->assertInstanceOf("Wally_Wordpress", $wp);
        
        //TODO: do it
        $wp = new Wally_Wordpress("www.walterdalmut.com", "walter", "wa1t3r83");
        $this->assertInstanceOf("Wally_Wordpress", $wp);
        
        $wp = new Wally_Wordpress("http://walterdalmut.com/blog", "walter", "wa1t3r83");
        $this->assertInstanceOf("Wally_Wordpress", $wp);
        
        $wp = new Wally_Wordpress("walterdalmut.com/blog", "walter", "wa1t3r83");
        $this->assertInstanceOf("Wally_Wordpress", $wp);
        
        $uri = Zend_Uri::factory("http://walterdalmut.com/blog");
        $wp = new Wally_Wordpress($uri, "walter", "wa1t3r83");
        $this->assertInstanceOf("Wally_Wordpress", $wp);
    }
    
    public function testCheckUrlPath()
    {
        $wp = new Wally_Wordpress("http://www.walterdalmut.com", "walter", "wa1t3r83");
        $this->assertEquals($wp->getHttpClient()->getUri()->getUri(), "http://www.walterdalmut.com:80/xmlrpc.php");
        
        $wp = new Wally_Wordpress("http://www.walterdalmut.com/xmlrpc.php", "walter", "wa1t3r83");
        $this->assertEquals($wp->getHttpClient()->getUri()->getUri(), "http://www.walterdalmut.com:80/xmlrpc.php");
        
        $wp = new Wally_Wordpress("www.walterdalmut.com/xmlrpc.php", "walter", "wa1t3r83");
        $this->assertEquals($wp->getHttpClient()->getUri()->getUri(), "http://www.walterdalmut.com:80/xmlrpc.php");
        
        $wp = new Wally_Wordpress("www.walterdalmut.com", "walter", "wa1t3r83");
        $this->assertEquals($wp->getHttpClient()->getUri()->getUri(), "http://www.walterdalmut.com:80/xmlrpc.php");
        
        $wp = new Wally_Wordpress("www.walterdalmut.com/blog", "walter", "wa1t3r83");
        $this->assertEquals($wp->getHttpClient()->getUri()->getUri(), "http://www.walterdalmut.com:80/blog/xmlrpc.php");
    }
    
    public function testBlogParams()
    {
        $wp = new Wally_Wordpress("www.walterdalmut.com/blog", "walter", "wa1t3r83");
        $wp->setBlogId(3);

        $this->assertEquals($wp->getBlogId(), 3);
        $this->assertEquals($wp->getUsername(), "walter");
        $this->assertEquals($wp->getPassword(), "wa1t3r83");
    }
    
}