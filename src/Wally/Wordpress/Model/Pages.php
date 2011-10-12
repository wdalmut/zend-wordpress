<?php

namespace Wally\Wordpress\Model;

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
class Pages
	extends Wally\Wordpress\Model\ArrayStruct
{
	public function find($name, $arg, $all = false, $operator = self::EQUALS)
	{
		if ($name == Wally\Wordpress\Model\Page::WP_DATE || $name == Wally\Wordpress\Model\Page::WP_DATE_GMT) {
			if (!($arg instanceof Zend\Date)) {
				throw new Zend\Date\Exception("You must set a Zend_Date instance");
			} else {
				$elements = array();
				foreach ($this->container as $element) {
					$status = false;
					switch ($operator) {
						case Wally\Wordpress\Model\ArrayAccessAbstract::EQUALS:
							$status = $element->$name->equals($arg);
							break;
						case Wally\Wordpress\Model\ArrayAccessAbstract::GREATER_THAN:
							$status = $element->$name->isLater($arg);
							break;
						case Wally\Wordpress\Model\ArrayAccessAbstract::LESS_THAN:
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
					case Wally\Wordpress\Model\ArrayAccessAbstract::EQUALS:
						$status = $element->$name == $arg;
						break;
					case Wally\Wordpress\Model\ArrayAccessAbstract::GREATER_THAN:
						$status = $element->$name > $arg;
						break;
					case Wally\Wordpress\Model\ArrayAccessAbstract::LESS_THAN:
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
