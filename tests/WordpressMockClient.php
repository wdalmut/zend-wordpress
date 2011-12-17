<?php

require_once ("Zend/Http/Client.php");

/**
 * @todo remove this class completely! 
 * You have to mock using PHPUnit mocking system. 
 */
class WordpressMockClient
    extends Zend_Http_Client
{
    private $_model;

    public function _generateLists($listName, $modelName, $extra = "aaa1")
    {
        $classname = "Wally_Wordpress_Model_{$listName}";
        $pages = new $classname();

        for ($i=1; $i<11; $i++) {
            $classname = "Wally_Wordpress_Model_{$modelName}";
            $model = new $classname();
            $model->title = strtolower($modelName) . "-{$i}";
            $model->username = "username-{$i}";
            $model->userid = $i;
            $model->userId = $i;
            $model->isAdmin = 1;
            $model->blogid = 1;
            $model->pageId = $i;
            $model->pageStatus = Wally_Wordpress::PUBLISH;
            $model->dateCreated = Zend_Date::now()->subDay($i);
            $model->dateCreatedGmt = Zend_Date::now()->subDay($i);
            $model->categoryName = "category-{$i}";
            $model->content = "Another content...";
            $model->name = "tag$i*2-{$i}";
            $model->count = $i*2;

            $pages[] = $model;
        }

        $this->_model = $pages;

        return $pages;
    }

    public function getPages($blogId = 1)
    {
        return $this->_generateLists("Pages", "Page", $blogId);
    }

    public function getTags($blogId = 1)
    {
        return $this->_generateLists("Tags", "Tag", $blogId);
    }

    public function getCategories($blogId = 1)
    {
        return $this->_generateLists("Categories", "Category", $blogId);
    }

    public function getPosts($numberOfPosts = 5, $blogId = 1)
    {
		if (is_array($numberOfPosts) && count($numberOfPosts)) {
			$numberOfPosts = $numberOfPosts[0];
        } else {
            $numberOfPosts = 5;
        }

        $posts =  $this->_generateLists("Posts", "Post", $blogId);

        $list = new Wally_Wordpress_Model_Posts();
        for ($i=0; $i<$numberOfPosts; $i++) {
            $list[] = $posts[$i];
        }
        return $list;
    }

    public function getAuthors($blogId = 1)
    {
        return $this->_generateLists("Authors", "Author", $blogId);
    }

    public function getUsersBlogs()
    {
        return $this->_generateLists("Authors", "Author");
    }

    public function save($model)
    {

    }

    public function delete($model)
    {

    }

    /**
     * Do nothing
     */
    public function request($method = null) 
    {
        return null;
    }
}
