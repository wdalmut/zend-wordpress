<?php 
namespace Wally;

class Compile
{

    public function compile($pharFile = 'zend-wordpress.phar')
    {
        $phar = new \Phar($pharFile);
        $phar->setSignatureAlgorithm(\Phar::SHA1);
        
        $phar->startBuffering();
        
        $phar->addFile(dirname(__FILE__) . "/Wordpress.php");
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Client.php", 'Wordpress/Client.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Abstract.php", 'Wordpress/Model/Abstract.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/ArrayAccessAbstract.php", 'Wordpress/Model/ArrayAccessAbstract.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/ArrayStruct.php", 'Wordpress/Model/ArrayStruct.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Author.php", 'Wordpress/Model/Author.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Authors.php", 'Wordpress/Model/Authors.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Categories.php", 'Wordpress/Model/Categories.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Category.php", 'Wordpress/Model/Category.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Comment.php", 'Wordpress/Model/Comment.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Comments.php", 'Wordpress/Model/Comments.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/CommentsFilter.php", 'Wordpress/Model/CommentsFilter.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Page.php", 'Wordpress/Model/Page.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Pages.php", 'Wordpress/Model/Pages.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Post.php", 'Wordpress/Model/Post.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Posts.php", 'Wordpress/Model/Posts.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Tag.php", 'Wordpress/Model/Tag.php');
        $phar->addFile(dirname(__FILE__) . "/Wordpress/Model/Tags.php", 'Wordpress/Model/Tags.php');
        
        //I have to add ZF1 some lib parts too...
        
        $phar->addFile(realpath(dirname(__FILE__) . "/../../LICENSE"));
        
        $phar->stopBuffering();
        
        $phar->compressFiles(\Phar::GZ);
        
        unset($phar);
    }
}