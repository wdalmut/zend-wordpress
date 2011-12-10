<?php 
namespace Wally;

/**
 * Phar compile procedure.
 * 
 * @author Walter Dal Mut
 *
 * @todo needs complete refactor
 */
class Compile
{
    private function _addDir($phar, $path, $stripPath, $suffix = '', $prefix = '', $exclude = array())
    {
        $fileIterator = \File_Iterator_Factory::getFileIterator(
            $path,
            $suffix, 
            $prefix, 
            $exclude
        );
        
        foreach ($fileIterator as $file) {
            if ($file->isFile()) {
                $path = str_replace($stripPath, "", $file->getPath());

                $phar->addFile($file, $path . "/" . $file->getFilename());
            }
        }
    }

    public function compile($pharFile = 'zend-wordpress.phar')
    {
        if (file_exists($pharFile)) {
            unlink($pharFile);
        }
        
        $phar = new \Phar($pharFile);
        $phar->setSignatureAlgorithm(\Phar::SHA1);
        
        $phar->startBuffering();
        
        $phar->addFile("autoload.php");
        
        $this->_addDir(
            $phar, 
            dirname(__FILE__), 
            realpath(dirname(__FILE__)."/../") . "/",
        	"php"
        );
        
        //Loader
        $phar->addFile(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Loader.php', 'Zend/Loader.php');
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Loader'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //XmlRpc
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/XmlRpc'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Http
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Http'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Uri
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Uri'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Date
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Date'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Cache
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Cache'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Filter
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Filter'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Validator
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Validator'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );
        
        //Validator
        $this->_addDir(
            $phar,
            realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Stdlib'),
            realpath(dirname(__FILE__) . '/../../vendor/zend/library') . '/',
            'php'
        );

        //Registry
        $phar->addFile(realpath(dirname(__FILE__) . '/../../vendor/zend/library/Zend/Registry.php'), 'Zend/Registry.php');
        
        $phar->addFile(realpath(dirname(__FILE__) . "/../../LICENSE"));
        
        $phar->setStub($this->getStub());
        
        $phar->stopBuffering();
        
//         $phar->compressFiles(\Phar::GZ);
        
        unset($phar);
    }
    
    protected function getStub()
    {
        return <<<'EOF'
    <?php
    /*
     * This file is part of the Zend Wordpress library
     *
     * (c) Walter Dal Mut <walter.dalmut@gmail.com>
     *
     * This source file is subject to the MIT license that is bundled
     * with this source code in the file LICENSE.
     */
    
    Phar::mapPhar('zend-wordpress.phar');
    
    require_once 'phar://zend-wordpress.phar/autoload.php';
    
    __HALT_COMPILER();
EOF;
    }
}
