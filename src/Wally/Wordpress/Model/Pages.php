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
    protected $_dateFields = array(
        Wally_Wordpress_Model_Page::WP_DATE,
        Wally_Wordpress_Model_Page::WP_DATE_GMT    
    );
}
