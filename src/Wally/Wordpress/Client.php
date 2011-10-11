<?php 
/**
 * 
 * The base XML-RPC Client
 * 
 * @author Walter Dal Mut
 *
 */
class Wally_Wordpress_Client
	extends Zend_XmlRpc_Client
{
	private $_username;
	private $_password;
	
	private $_blogId = 1;
	
	public function getUsersBlogs()
	{
		$list = $this->_wpMethod("getUsersBlogs");
		
		return $this->_toPages($list, "Author", "Authors");
	}
	
	public function getAuthors($blogId = false)
	{
		return $this->_getAuthorsOfBlog($blogId);
	}
	
	protected function _getAuthorsOfBlog($blogId = false)
	{
		if (!$blogId) {
			$blogId = $this->_blogId;
		}
		
		$list = $this->_wpMethod(
			"getAuthors", 
			array('blog_id' => $blogId)
		);
		
        $default = $this->_toPages($list, "Author", "Authors");
		
		return $default;
	}
	
	public function getCategories($blogId = 1)
	{
	    $list = $this->_wpMethod("getCategories", array("blog_id" => $blogId));
	    return $this->_toPages($list, "Category", "Categories");
	}
	
	public function getTags($blogId = 1)
	{
	    $list = $this->_wpMethod("getTags", array("blog_id" => $blogId));
	    return $this->_toPages($list, "Tag", "Tags");
	}

	/**
	 * 
	 * Get comments of a given post
	 * 
	 * @param mixed|Zend_Wordpress_Model_Post $post The post that you want comments use the 
	 * 	Wally_Wordpress_Model_Post or Wally_Wordpress_Model_Page
	 * @param int $blogId The blog identification number
	 * 
	 * @throws Zend_Exception in case of errors
	 * 
	 * @return Wally_Wordpress_Model_Comments The comments structure
	 */
	public function getComments($post, $blogId = 1)
	{
	    if (is_array($post)) {
	        $post = $post[0];
	        
	        if (!($post instanceof Wally_Wordpress_Model_Page)) {
	            throw new Zend_Exception("Only models of post and page are valid. Use the right models.");
	        }
	    }
	    
	    $struct = array(
	    	'post_id' => $post->postid, 
	    );
	    
	    $struct = array_merge($post->getCommentsFilter()->toArray(), $struct);
	    
	    $list = $this->_wpMethod(
	        'getComments',
	        array('blog_id' => $blogId), 
	        array($struct)
	    );
	    
	    return $this->_toPages($list, "Comment", "Comments");
	}
	
	public function getPosts($numberOfPosts = 5, $blogId = false) 
	{
		if (is_array($numberOfPosts) && count($numberOfPosts)) {
			$numberOfPosts = $numberOfPosts[0];
		}
		
		$list = $this->_wpMethod(
			"getRecentPosts", 
			array('app_key' => '', 'blog_id' => $blogId),
			array('numberOfPosts' => $numberOfPosts),
			"blogger"
		);
		
		$default = $this->_toPages($list, "Post", "Posts");
		
		return $default;
	}
	
	/**
	 * Get pages from your blog
	 * 
	 * @param int $blogId
	 * 
	 * @return Wally_Wordpress_Model_Pages Your pages
	 */
	public function getPages($blogId = false)
	{
		return $this->_getPagesOfBlog($blogId);
	}
	
	protected function _getPagesOfBlog($blogId = false)
	{
		if (!$blogId) {
			$blogId = $this->_blogId;
		}
	
		$list = $this->_wpMethod(
			"getPages", 
			array('blog_id' => $blogId)
		);
		
		return $this->_toPages($list);
	}
	
	protected function _wpMethod($method, array $args = array(), array $args_post = array(), $prefix = "wp")
	{
	    $this->setSkipSystemLookup(true);
	    
		$data = array_merge(  
			array_merge(
				$args,
				array(
					'username' => $this->_username, 
					'password' => $this->_password
				)
			),
			$args_post
		);
		
		return $this->call(
			"{$prefix}.{$method}", 
			$data
		);
	}
	
	public function delete($model, $blogId = 1) 
	{
	    $ret = false;
	    
	    if (is_array($model)) {
	        $model = $model[0];
	    }
	    
	    if ($model instanceof Wally_Wordpress_Model_Post) {
	        $ret = $this->_wpMethod("deletePost", array('blog_id' => $blogId, "postid" => $model->postid), array(), "blogger");
	    } else if ($model instanceof Wally_Wordpress_Model_Page) {
            $ret = $this->_wpMethod("deletePage", array("blog_id" => $blogId), array("page_id" => $model->pageId));
	    }
	    
	    return $ret;
	}
	
	public function save($model, $blogId = 1)
	{
	    $result = false;
	    
		if (is_array($model)) {
			$model = $model[0];
		}
		
		if ($model instanceof Wally_Wordpress_Model_Post) {
		    $content = $model->toArray();
		    $content = $content["content"];
		    
		    if (isset($model->postid)) {
		        $this->_wpMethod("editPost", array('appkey' => '', "postid" => $model->postid), array('content' => $content, 'publish' => true), 'blogger');
		    } else {
                $this->_wpMethod("newPost", array('appkey' => '', 'blog_id' => $blogId), array('content' => $content, 'publish' => true), "blogger");
		    }
		} else if($model instanceof Wally_Wordpress_Model_Comment) {
            if (isset($model->commentId)) {
                
                $newModel = new Wally_Wordpress_Model_Comment();
                $newModel->status = $model->status;
                $newModel->content = $model->content;
                $newModel->author = $model->author;
                $newModel->authorUrl = $model->authorUrl;
                $newModel->authorEmail = $model->authorEmail;

                $this->_wpMethod("editComment", array('blog_id' => $blogId), array('comment_id' => $model->commentId, 'comment' => $newModel->toArray()));
            } else {
                //TODO: check page or post?
                if (!$model->getPost() || !$model->getPost()->postid) {
                    throw new Zend_Exception("You must set the post for create a new comment.");
                }
                
                $postId = $model->getPost()->postid;
                $this->_wpMethod('newComment', array('blog_id' => $blogId), array('post_id' => $postId, 'comment' => $model->toArray()));
            }
		} else if ($model instanceof Wally_Wordpress_Model_Page) {
		    if (isset($model->pageId)) {
		        
		        if (isset($model->dateCreated)) {
		            unset($model->dateCreated);
		        }
		        
		        if (isset($model->dateCreatedGmt)) {
		            unset($model->dateCreatedGmt);
		        }
		        
		        $result = $this->_wpMethod("editPage", array("blog_id" => $blogId, "page_id" => $model->pageId), array("content" => $model->toArray(), "publish" => false));
		    } else {
			    $result = $this->_wpMethod("newPage", array("blog_id" => $blogId), array("content" => $model->toArray()));
		    }
		} else {
			throw new Zend_Exception("Unknow model");
		}
		
		return $result;
	}
	
	public function setUsername($username)
	{
		$this->_username = $username;
	}
	
	public function getUsername()
	{
	    return $this->_username;
	}
	
	public function setPassword($password)
	{
		$this->_password = $password;
	}
	
	public function getPassword()
	{
	    return $this->_password;
	}
	
	public function setBlogId($id)
	{
		$this->_blogId = $id[0];
	}
	
	public function getBlogId()
	{
	    return $this->_blogId;
	}
	
	private function _toPages($list, $class = "Page", $parentClass = "Pages")
	{
	    $classname = "Wally_Wordpress_Model_{$class}";
	    $parentClassname = "Wally_Wordpress_Model_{$parentClass}";
	    
		$default = new $parentClassname();
		foreach ($list as $a => $b) {
			$s = new $classname();
			foreach ($b as $k => $w) {
				$t = new Zend_Filter();
				$t->addFilter(new Zend_Filter_Word_SeparatorToCamelCase("_"));
		
				$r = Wally_Wordpress_Tool::lcfirst($t->filter($k));
				$s->$r = $w;
			}
		
			$default[] = $s;
		}
		
		return $default;
	}
}