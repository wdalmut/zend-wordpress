<?php

namespace Wally\Wordpress\Model;

/**
 * 
 * Comment base model class
 * 
 * @author Walter Dal Mut
 *
 */ 
class Comment
    extends Wally\Wordpress\Model\Page
{
    private $_post;
    
    public function setPost(Wally\Wordpress\Model\Page $post)
    {
        $this->_post = $post;
    }
    
    public function getPost()
    {
        return $this->_post;
    }
}
