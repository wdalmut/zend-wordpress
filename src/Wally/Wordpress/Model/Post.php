<?php
/** 
 * 
 * This class model a post of blog
 * 
 * @author Walter Dal Mut
 *
 */
class Wally_Wordpress_Model_Post
    extends Wally_Wordpress_Model_Page
{
    const TITLE = 'title';
    const CONTENT = 'content';
    const CATEGORY = 'category';
    
    private $_commentsFilter;

    public function __set($key, $value) {
        //Posts are simil-xml structure into the content...
        //That is terrible...
        if (!$this->__isset(self::TITLE) && $key == self::CONTENT) {
            $start = "<" . self::TITLE .">";
            $stop = "</" . self::TITLE . ">";
        
            //Create the title element
            $initTitle = strpos($value, $start) + strlen($start);
            $endTitle = strpos($value, $stop);
        
            $this->title = substr($value, $initTitle, $endTitle-$initTitle);
            $value = str_replace($start . $this->title . $stop, "", $value);
            
            $start = "<" . self::CATEGORY . ">";
            $stop = '</' . self::CATEGORY . ">";
            
            //Create the title element
            $initCategory = strpos($value, $start) + strlen($start);
            $endCategory = strpos($value, $stop);
        
            $this->category = substr($value, $initCategory, $endCategory-$initCategory);
            $value = str_replace($start . $this->category . $stop, "", $value);
        }
        
        parent::__set($key, $value);
    }
    
    public function toArray()
    {
        $startTitle = "<" . self::TITLE .">";
        $stopTitle = "</" . self::TITLE . ">";
        
        $startCategory = "<" . self::CATEGORY . ">";
        $stopCategory = '</' . self::CATEGORY . ">";

        $title = self::TITLE;
        $content = self::CONTENT;
        $category = self::CATEGORY;
        $this->$content = 
            $startTitle . 
            $this->$title . 
            $stopTitle . 
            $startCategory . 
            $this->$category . 
            $stopCategory . 
            $this->$content;
        
        $this->__unset(self::TITLE);
        $this->__unset(self::CATEGORY);
        
        return parent::toArray();;
    }
    
    public function setCommentsFilter(Wally_Wordpress_Model_CommentsFilter $commentsFilter)
    {
        $this->_commentsFilter = $commentsFilter;
    }
    
    public function getCommentsFilter()
    {
        return $this->_commentsFilter;
    }
}