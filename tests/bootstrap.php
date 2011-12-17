<?php 

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
