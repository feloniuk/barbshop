<?php
/**
 * Mcache
 */

class Mcache extends Memcached // WINDOWS -> Memcache ,else -> Memcached
{

    function __construct($host, $port)
    {
        parent::__construct();
        $this->addServer($host, $port);
    }

    // Only for WINDOWS environment, where no memcached
//    function set($key, $var, $expire = null)
//    {
//        $flag = null;
//        parent::set($key, $var, $flag, $expire);
//    }
}




class MyCache
{
    private static $_cache = false;


    private static function checkConnect()
    {
        if (self::$_cache === false) {
            self::$_cache = new Mcache('localhost', 11211);
        }
    }

    public static function get($key)
    {
        self::checkConnect();

        if (self::$_cache !== false) {
            return self::$_cache->get($key);
        }

        return false;
    }

    public static function set($key, $value, $expire = null)
    {
        self::checkConnect();

        if (self::$_cache !== false) {
            return self::$_cache->set($key, $value, $expire);
        }

        return false;
    }

    public static function delete($key, $time = 0)
    {
        self::checkConnect();

        if (self::$_cache !== false) {
            return self::$_cache->delete($key, $time);
        }

        return false;
    }
}


/* End of file */