<?php 
set_include_path(implode(PATH_SEPARATOR,  array(
    realpath(dirname(__FILE__) . '/../src'),
    get_include_path(),
)));

//Zend autoloader
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();

$autoloader->registerNamespace("Wally_");
$autoloader->registerNamespace("Zend_");

define("HOST", "http://test.wp.local");
define("USERNAME", "admin");
define("PASSWORD", "walter");

define("USER_ID", 1);
define("TAG_NAME", "amazon");
define("CATEGORY_NAME", "Cats");
define("PAGE_TITLE", "Blog");
define("CREATE_PAGE_TITLE", "XMLRPC Create");
define("CREATE_PAGE_DESCRIPTION", "This is the content");

define("POST_TITLE", "Walter post");
define("CREATE_POST_TITLE", "POST XMLRPC Create");
define("CREATE_POST_DESCRIPTION", "This is the content of the posts.");

Zend_Registry::set("wp", new Wally_Wordpress(HOST, USERNAME, PASSWORD));