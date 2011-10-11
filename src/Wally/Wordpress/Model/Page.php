<?php
/**
 * 
 * Page model.
 * 
 * This class model a Page of blog.
 * 
 * @author Walter Dal Mut
 *
 */
class Wally_Wordpress_Model_Page
	extends Wally_Wordpress_Model_Abstract
{
	const WP_DATE = 'dateCreated';
	const WP_DATE_GMT = 'dateCreatedGmt';
	
	public function __set($key, $value)
	{
		if ($key == self::WP_DATE || $key == self::WP_DATE_GMT) {
			$value = new Zend_Date($value, Zend_Date::ISO_8601);
		}
		
		parent::__set($key, $value);
	}
	
	public function toArray()
	{
		$data = $this->_data;
		
		$clear = array();
		foreach ($data as $key => $value) {
		    if ($key != self::WP_DATE) {
    			$f = new Zend_Filter;
    			$f->addFilter(new Zend_Filter_Word_CamelCaseToSeparator("_"));
    			$f->addFilter(new Zend_Filter_StringToLower());
    			$key = $f->filter($key);
		    }
		    
		    if ($value instanceof Zend_Date) {
		        $value = $value->toString("yyyyMMddTHHmmss");
		    }
		    
			$clear[$key] = $value;
		}
		
		return $clear;
	}
}