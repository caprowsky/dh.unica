<?php

use WPMVC\PHPFastCache\phpFastCache;
use WPMVC\PHPFastCache\phpFastCache_instances;

/**
 * Global functions.
 */

// short function
if(!function_exists("__c")) {
	function __c($storage = "", $option = array()) {
		return phpFastCache($storage, $option);
	}
}

// main function
if(!function_exists("phpFastCache")) {
	function phpFastCache($storage = "auto", $config = array()) {
        $storage = strtolower($storage);
        if(empty($config)) {
            $config = phpFastCache::$config;
        }

        if($storage == "" || $storage == "auto") {
            $storage = phpFastCache::getAutoClass($config);
        }


        $instance = md5(json_encode($config).$storage);
		if(!isset(phpFastCache_instances::$instances[$instance])) {
            $class = "phpfastcache_".$storage;
            phpFastCache::required($storage);
			phpFastCache_instances::$instances[$instance] = new $class($config);
		}

		return phpFastCache_instances::$instances[$instance];
	}
}