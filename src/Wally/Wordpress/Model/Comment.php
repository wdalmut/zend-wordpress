<?php
/**
 * 
 * Comment base model class
 * 
 * @author Walter Dal Mut
 *
 */ 
class Wally_Wordpress_Model_Comment
    extends Wally_Wordpress_Model_Page
{
    private $_post;
    
    public function setPost(Wally_Wordpress_Model_Page $post)
    {
        $this->_post = $post;
    }
    
    public function getPost()
    {
        return $this->_post;
    }
}