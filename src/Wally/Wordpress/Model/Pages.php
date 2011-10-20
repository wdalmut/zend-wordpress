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
	extends \Wally\Wordpress\Model\ArrayStruct
{
    protected $_dateFields = array(
        \Wally\Wordpress\Model\Page::WP_DATE,
        \Wally\Wordpress\Model\Page::WP_DATE_GMT    
    );
}
