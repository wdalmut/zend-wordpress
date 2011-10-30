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

    /**
     * Sort by a defined field
     *
     * The alghoritm used is the bubble sort. This method
     * modify the actual struct and no another one is
     * created (mutable type). Use the prototype pattern
     * for sort a duplicate structure.
     *
     * @param $name Field to use during sorting
     * @param $arg The order of sort
     *
     */
    public function sort($name, $arg)
    {
        for ($i=0; $i<$this->count(); $i++) {
            for ($j=0; $j<($this->count()-1); $j++) {
                if (is_numeric($this[$i]->$name )){
                    $this->_sortNumeric($name, $j, $arg);
                } else if (is_string($this[$i]->$name)) {
                    $this->_sortString($name, $j, $arg);
                } else if ($this[$i]->$name instanceof Zend_Date) {
                    $this->_sortDate($name, $j, $arg);
                }
            }
        }
    }

    private function _swap( $a , $b ) {
        $tmp = $this[$a];
        $this[$a] = $this[$b];
        $this[$b] = $tmp;
    }

    private function _sortNumeric($name, $j, $operator)
    {
        if ($operator == self::ASC) {
            if ($this[$j+1]->$name < $this[$j]->$name){
                $this->_swap( $j, $j+1);
            }
        } else {
            if ($this[$j+1]->$name > $this[$j]->$name){
                $this->_swap( $j, $j+1);  
            }
        }
    }

    private function _sortString($name, $j, $operator)
    {
        if ($operator == self::ASC) {
            if (strcmp( $this[$j+1]->$name ,  $this[$j]->$name ) < 0) {
                $this->_swap( $j, $j+1);
            }
        } else {
            if (strcmp( $this[$j+1]->$name ,  $this[$j]->$name ) > 0) {
                $this->_swap( $j, $j+1);  
            }
        }
    }

    private function _sortDate($name, $j, $operator)
    {
        if ($operator == self::ASC) {
            if ($this[$j+1]->$name->isEarlier( $this[$j]->$name)) {
                $this->_swap( $j, $j+1);
            }
        } else {
            if ($this[$j+1]->$name->isLater( $this[$j]->$name)) {
                $this->_swap( $j, $j+1);  
            }
        }
    }
}
