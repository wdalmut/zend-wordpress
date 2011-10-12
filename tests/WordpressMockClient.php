<?php

require_once ("Zend/Http/Client.php");

class WordpressMockClient
    extends Zend_Http_Client
{
    private $_model;

    public function _generateLists($listName, $modelName, $extra = "aaa1")
    {
        $classname = "Wally_Wordpress_Model_{$listName}";
        $pages = new $classname();


        for ($i=0; $i<10; $i++) {
            $classname = "Wally_Wordpress_Model_{$modelName}";
            $model = new $classname();
            $model->title = strtolower($modelName) . "-{++$i}-{$extra}";
            $model->username = "username-{++$i}-{$extra}";

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

    public function getPosts($postCount = 5, $blogId = 1)
    {
        $posts =  $this->_generateLists("Posts", "Post", $blogId);

        $list = new Wally_Wordpress_Model_Posts();
        for ($i=0; $i<$postCount; $i++) {
            $list[] = $post[$i];
        }
        return $posts;
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
