<?php 
/**
 * Class used for 5.x porting
 *
 * @author Walter Dal Mut
 */ 
class Wally_Wordpress_Tool
{
    /**
     * Lower case the first character of a string
     *
     * @param string $string The string to filter
     * @return string The string with the first character lowered
     */
	public static function lcfirst($string)
	{
		return strtolower($string{0}) . substr($string, 1);
	}
}
