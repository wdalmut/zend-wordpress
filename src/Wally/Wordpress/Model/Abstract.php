<?php 

namespace Wally\Wordpress\Model;

/**
 * Abstract model base
 * 
 * @author Walter Dal Mut
 *
 */
abstract class Abstract
{
	protected $_data;
    protected $_dateFields = array();

    protected $_dateFormat = "yyyyMMddTHHmmss";
	
	public function __construct()
	{
	    $this->_data = array();
	}
	
	/**
	 * Retrieve message field value
	 *
	 * @param  string $key The user-specified key name.
	 * @return string      The corresponding key value.
	 * @throws Zend_Queue_Exception if the $key is not a column in the message.
	 */
	public function __get($key)
	{
		if (!array_key_exists($key, $this->_data)) {
			require_once 'Zend/Exception.php';
			throw new Wally\Wordpress\Exception\RuntimeException("Specified field \"$key\" is not in the message");
		}
		return $this->_data[$key];
	}
	
	/**
	 * Set message field value
	 *
	 * @param  string $key   The message key.
	 * @param  mixed  $value The value for the property.
	 * @return void
	 * @throws Wally\Wordpress\Exception\RuntimeException
	 */
	public function __set($key, $value)
	{
        //Dates are converted using zend_date
        if (in_array($key, $this->_dateFields)) {
            $value = new Zend_Date($value, $this->_dateFormat);
        }

        //Store the value
		$this->_data[$key] = $value;
	}
	
	/**
	 * Test existence of message field
	 *
	 * @param  string  $key The column key.
	 * @return boolean
	 */
	public function __isset($key)
	{
		return array_key_exists($key, $this->_data);
	}
	
	public function __unset($name)
	{
	    unset($this->_data[$name]);
	}
	
	/**
	 * Returns the column/value data as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$data = $this->_data;
		
		$clear = array();
		foreach ($data as $key => $value) {
			$f = new Zend\Filter;
			$f->addFilter(new Zend\Filter\Word\CamelCaseToSeparator("_"));
			$f->addFilter(new Zend\Filter\StringToLower());
			$key = $f->filter($key);
			$clear[$key] = $value;
		}
		
		return $clear;
	}
}
