<?php
/**
 * 
 * Array Access abstract class
 * 
 * @author Walter Dal Mut
 *
 */
abstract class Wally_Wordpress_Model_ArrayAccessAbstract
	implements ArrayAccess, Iterator, Countable 
{
	private $position = 0;
	protected $container = array();
	
	const EQUALS = 0;
	const GREATER_THAN = 1;
	const LESS_THAN = 2;

    const ASC = 0;
    const DESC = 1;


    private $_orders = array(
        'Asc' => self::ASC,
        'Asc' => self::ASC,
        'Ascending' => self::ASC,
        'Descending' => self::DESC
    );
	
	//ArrayAccess
	public function __construct() {
		$this->position = 0;
		$this->container = array();
	}
	
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}
	
	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}
	
	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}
	
	public function offsetGet($offset) {
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}
	
	public function rewind() {
		$this->position = 0;
	}
	
	public function current() {
		return $this->container[$this->position];
	}
	
	public function key() {
		return $this->position;
	}
	
	public function next() {
		++$this->position;
	}
	
	public function valid() {
		return isset($this->container[$this->position]);
	}
	
	//Countable
	public function count() {
		return count($this->container);
	}
	
	public function __call($method, $arguments)
	{

		if (@preg_match('/(find(?:One|All)?(?:By|GreaterThan|LessThan))(.+)/', $method, $match)) {
			return $this->{$match[1]}(lcfirst($match[2]), $arguments[0]);
		} else if (@preg_match('/(sortBy(.+)Ordering(?:' . implode("|", array_keys($this->_orders)) . '))(.+)/', $method, $match)) {
            return $this->{$match[1]}(lcfirst($match[1]), $this->_orders[$match[2]]);
        } else {
			throw new Zend_Exception("Method {$method} not allowed. Use findBy or sortBy magic methods");
		}
	}
	
	public function findOneGreaterThan($name, $arg)
	{
		return $this->find($name, $arg, false, self::GREATER_THAN);
	}
	
	public function findAllGreaterThan($name, $arg)
	{
		return $this->find($name, $arg, true, self::GREATER_THAN);
	}
	
	public function findOneLessThan($name, $arg)
	{
		return $this->find($name, $arg, false, self::LESS_THAN);
	}
	
	public function findAllLessThan($name, $arg)
	{
		return $this->find($name, $arg, true, self::LESS_THAN);
	}
	
	public function findOneBy($name, $arg)
	{
		return $this->find($name, $arg, false, self::EQUALS);
	}
	
	public function findAllBy($name, $arg)
	{
		return $this->find($name, $arg, true, self::EQUALS);
	}

    public function sortBy($field, $order = self::ASC)
    {
        $this->sort($field, $order);
    }
	
	abstract public function find($name, $arg, $all = false, $operator = self::EQUALS);
	abstract public function sort($name, $arg);
}

if (!function_exists("lcfirst")) {
    function lcfirst($string)
    {
        return strtolower($string{0}) . substr($string, 1);
    }
}
