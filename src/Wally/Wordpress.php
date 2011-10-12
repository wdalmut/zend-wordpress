<?php 
/**
 * 
 * The Main Access Point of Wordpress Library
 *
 * @author Walter Dal Mut
 */
class Wally_Wordpress
{
	/**
	 * Page publish status const
	 * @var string The status
	 */
	const PUBLISH = 'publish';
	/**
	* Page draft status const
	* @var string The status
	*/
	const DRAFT = 'draft';
	/**
	 * Page private status const
	 * @var string The status
	 */
	const RESERVED = 'private';
	/**
	 * Comment spam status const
	 * @var string The status
	 */
	const COMMENT_SPAM = 'spam';
	/**
	 * Comment trash status const
	 * @var string The status
	 */
	const COMMENT_TRASH = 'trash';
	/**
	 * Comment approved status const
	 * @var string The status
	 */
	const COMMENT_APPROVED = 'approve';
	/**
	 * Comment unapproved status const
	 * @var string The status
	 */
	const COMMENT_UNAPPROVED = 'hold';
	/**
	 * Comment all statuses const
	 * @var string The status
	 */
	const COMMENT_ALL = '';
	
	/**
	 * The remote host
	 * @var string
	 */
	private $_host;
	
	/**
	 * The username
	 * @var string
	 */
	private $_username;
	
	/**
	 * The password
	 * 
	 * @var string
	 */
	private $_password;
	
	/**
	 * Enter description here ...
	 * @var Wally_Wordpress_Client
	 */
	private $_client;
	
	/**
	 * 
	 * Crete the Wordpress Connection
	 * 
	 * @param string|Zend_Uri $host The host
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($host, $username, $password)
	{
		$host = $this->_setUri($host);
		
		$this->_host = $host->getUri();
		$this->_username = $username;
		$this->_password = $password;
		
		$this->_init();
	}

    /**
     * Dependency injection
     * 
     * Useful method for testing
     *
     * @param Zend_Http_Client $client The client
     */
    public function setClient($client)
    {
        $this->_client = $client;
    }
	
	/**
	 * Strategy pattern  for extensions
	 *  
	 * If you need to extends library.
	 */
	protected function _init()
	{
		$this->_client = new Wally_Wordpress_Client($this->_host);
		$this->_client->setUsername($this->_username);
		$this->_client->setPassword($this->_password);
		
		$this->_client->setHttpClient(new Zend_Http_Client($this->_host));
	}
	
	public function __call($method, $args)
	{
		return $this->_client->$method($args);
	}
	
	/**
	 * 
	 * Work on blog uri
	 * 
	 * @param Zend_Uri|string $uri The user URI
	 * 
	 * @return Zend_Uri The real URI
	 */
	protected function _setUri($uri)
	{
	    if (!($uri instanceof Zend_Uri)) {
	        //transform to Zend_Uri
	        if (strpos($uri, "http://") === false) {
	            $uri = "http://{$uri}";
	            
	            $uri = Zend_Uri::factory($uri);
	        } else {
	            $uri = Zend_Uri::factory($uri);
	        }
	    }

	    $path = $uri->getPath();
	     
	    if (strpos($path, "xmlrpc.php") === false) {
	        $slash = '';
	        $pos = strrpos($path, "/")+1;
	        if (strlen($path) != $pos) {
	            $slash = '/';
	        }
	        
	        $uri->setPath($uri->getPath() . $slash . "xmlrpc.php");
	    }
	    
	    return $uri;
	}
}
