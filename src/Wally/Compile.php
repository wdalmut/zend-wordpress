<?php 
namespace Wally;

class Compile
{

    public function compile($pharFile = 'zend-wordpress.phar')
    {
        $phar = new \Phar($pharFile);
        $phar->setSignatureAlgorithm(\Phar::SHA1);
        
        $phar->startBuffering();
        
        $phar->addFile(dirname(__FILE__) . "/Wordpress.php", 'Wally/Wordpress.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Client.php", 'Wally/Wordpress/Client.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Abstract.php", 'Wally/Wordpress/Model/Abstract.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/ArrayAccessAbstract.php", 'Wally/Wordpress/Model/ArrayAccessAbstract.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/ArrayStruct.php", 'Wally/Wordpress/Model/ArrayStruct.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Author.php", 'Wally/Wordpress/Model/Author.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Authors.php", 'Wally/Wordpress/Model/Authors.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Categories.php", 'Wally/Wordpress/Model/Categories.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Category.php", 'Wally/Wordpress/Model/Category.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Comment.php", 'Wally/Wordpress/Model/Comment.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Comments.php", 'Wally/Wordpress/Model/Comments.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/CommentsFilter.php", 'Wally/Wordpress/Model/CommentsFilter.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Page.php", 'Wally/Wordpress/Model/Page.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Pages.php", 'Wally/Wordpress/Model/Pages.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Post.php", 'Wally/Wordpress/Model/Post.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Posts.php", 'Wally/Wordpress/Model/Posts.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Tag.php", 'Wally/Wordpress/Model/Tag.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Tags.php", 'Wally/Wordpress/Model/Tags.php');
        
        //I have to add ZF1 some lib parts too...
        
        $phar->addFile(realpath(dirname(__FILE__) . "/../../LICENSE"));
        
        $phar->stopBuffering();
        
        $phar->compressFiles(\Phar::GZ);
        
        unset($phar);
    }
}