<?php 

require_once "WordpressMockClient.php";

set_include_path(implode(PATH_SEPARATOR,  array(
    realpath(dirname(__FILE__) . '/../src'),
realpath(dirname(__FILE__) . '/../vendor/zend'),
    get_include_path(),
)));

//Zend autoloader
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();

$autoloader->registerNamespace("Wally_");
$autoloader->registerNamespace("Zend_");

define("HOST", "http://localhost/");
define("USERNAME", "");
define("PASSWORD", "");

define("USER_ID", 1);
define("TAG_NAME", "tag-1");
define("CATEGORY_NAME", "category-1");
define("PAGE_TITLE", "page-1");
define("CREATE_PAGE_TITLE", "XMLRPC Create");
define("CREATE_PAGE_DESCRIPTION", "This is the content");

define("POST_TITLE", "post-1");
define("CREATE_POST_TITLE", "POST XMLRPC Create");
define("CREATE_POST_DESCRIPTION", "This is the content of the posts.");

$wp = new Wally_Wordpress(HOST, USERNAME, PASSWORD);
$wp->setClient(new WordpressMockClient());
Zend_Registry::set("wp", $wp);
