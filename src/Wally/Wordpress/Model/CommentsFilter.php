<?php 

namespace Wally\Wordpress\Model;

/**
 * 
 * Filter model class for comments
 * 
 * This class provide mechanism for
 * filter comments of a given post
 * 
 * @author Walter Dal Mut
 *
 */
class CommentsFilter
{
    private $_offset;
    private $_status;
    private $_limit;
    
    /**
     * Assign to post
     * @var Wally_Wordpress_Model_Post The post
     */
    private $_post;
    
    public function setOffset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }
    
    public function getOffset()
    {
        return $this->_offset;
    }
    
    public function setStatus($status)
    {
        $this->_status = $status;
        return $this;
    }
    
    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }
    
    public function getLimit()
    {
        return $this->_limit;
    }
    
    public function setPost(Wally\Wordpress\Model\Post $post)
    {
        $this->_post = $post;
        return $this;
    }
    
    public function getPost()
    {
        return $this->_post;
    }
    
    public function toArray()
    {
        $status = array();
        if ($this->_status != Wally\Wordpress::COMMENT_ALL) {
            $status = array('status' => $this->_status);
        }
        
        $status = array_merge(
            array(
            	'offset' => $this->_offset,
            	'number' => $this->_limit
        	),
        	$status
        );
        
        return $status;
    }
}
