<?php 
require_once 'Zend/Loader/StandardAutoloader.php';

use \Zend\Loader\StandardAutoloader as Loader;

$loader = new Loader();

$loader->registerNamespace('Zend', __DIR__ . '/Zend');
$loader->registerNamespace('Wally', __DIR__ . '/Wally');

$loader->register();