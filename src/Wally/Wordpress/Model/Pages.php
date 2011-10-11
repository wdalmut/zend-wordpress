<?php
/**
 * 
 * Pages array access base class
 * 
 * This class provides mechanism for working
 * with pages.
 * 
 * @author Walter Dal Mut
 *
 */
class Wally_Wordpress_Model_Pages
	extends Wally_Wordpress_Model_ArrayStruct
{
	public function find($name, $arg, $all = false, $operator = self::EQUALS)
	{
		if ($name == Wally_Wordpress_Model_Page::WP_DATE || $name == Wally_Wordpress_Model_Page::WP_DATE_GMT) {
			if (!($arg instanceof Zend_Date)) {
				throw new Zend_Date_Exception("You must set a Zend_Date instance");
			} else {
				$elements = array();
				foreach ($this->container as $element) {
					$status = false;
					switch ($operator) {
						case Wally_Wordpress_Model_ArrayAccessAbstract::EQUALS:
							$status = $element->$name->equals($arg);
							break;
						case Wally_Wordpress_Model_ArrayAccessAbstract::GREATER_THAN:
							$status = $element->$name->isLater($arg);
							break;
						case Wally_Wordpress_Model_ArrayAccessAbstract::LESS_THAN:
							$status = $element->$name->isEarlier($arg);
							break;
					}
					
					if ($status) {
						if (!$all) {
							return $element;
						} else {
							$elements[] = $element;
						}
					}
				}
			}
		} else {
			$elements = array();
			foreach ($this->container as $element) {
				
				$status = false;
				switch ($operator) {
					case Wally_Wordpress_Model_ArrayAccessAbstract::EQUALS:
						$status = $element->$name == $arg;
						break;
					case Wally_Wordpress_Model_ArrayAccessAbstract::GREATER_THAN:
						$status = $element->$name > $arg;
						break;
					case Wally_Wordpress_Model_ArrayAccessAbstract::LESS_THAN:
						$status = $element->$name < $arg;
						break;
				}
				
				if ($status) {
					if (!$all) {
						return $element;
					} else {
						$elements[] = $element;
					}
				}
			}
		}
		
		if (count($elements)) {
		    return $elements;
		} else {
		    return false;
		}
	}
}