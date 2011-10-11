<?php
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
class Wally_Wordpress_Model_ArrayStruct
    extends Wally_Wordpress_Model_ArrayAccessAbstract
{
    public function find($name, $arg, $all = false, $operator = self::EQUALS)
    {
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
    
        if (count($elements)) {
            return $elements;
        } else {
            return false;
        }
    }
}