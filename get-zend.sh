#!/bin/sh

HOST="http://zend.googlecode.com/svn/tags/Zend/Zend-1.11.11.tgz"

#wget -O zend.tgz $HOST
curl -o zend.tgz $HOST
mkdir -p vendor/zend
tar -C vendor/zend -xpzf zend.tgz 
mv vendor/zend/Zend-1.11.11 vendor/zend/Zend

rm -f zend.tgz