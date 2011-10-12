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
    protected $_dateFields = array(
        Wally_Wordpress_Model_Page::WP_DATE,
        Wally_Wordpress_Model_Page::WP_DATE_GMT    
    );
}
