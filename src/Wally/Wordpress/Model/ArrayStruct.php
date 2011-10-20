<?php

namespace Wally\Wordpress\Model;

/**
 * 
 * Array struct base class
 * 
 * This class provide mininal and typical 
 * configuration for Array Access abstract
 * model.
 * 
 * @author Walter Dal Mut
 *
 */ 
class ArrayStruct
    extends \Wally\Wordpress\Model\ArrayAccessAbstract
{
	public function find($name, $arg, $all = false, $operator = self::EQUALS)
	{
		if ($arg instanceof Zend\Date) {
			$elements = new $this();
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
		} else {
			$elements = new $this();
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
