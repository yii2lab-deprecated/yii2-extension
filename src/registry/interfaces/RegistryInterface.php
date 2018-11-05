<?php

namespace yii2lab\extension\registry\interfaces;

interface RegistryInterface {
	
	static function get($key = null, $default = null);
	static function has($key);
	static function set($key, $value);
	static function remove($key);
	static function reset();
	static function load($data);
	
}
