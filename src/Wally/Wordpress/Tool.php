<?php 
class Wally_Wordpress_Tool
{
	public static function lcfirst($string)
	{
		return strtolower($string{0}) . substr($string, 1);
	}
}