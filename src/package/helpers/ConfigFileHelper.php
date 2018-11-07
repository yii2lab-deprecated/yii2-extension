<?php

namespace yii2lab\extension\package\helpers;

use yii2lab\extension\store\StoreFile;

class ConfigFileHelper {
	
	const CONFIG_FILE = 'composer.json';
	
	public static function load($dir): array {
		$store = new StoreFile($dir . DS . self::CONFIG_FILE);
		return $store->load();
	}
	
	public static function save($dir, array $data) {
		$oldData = self::load($dir);
		if($oldData == $data) {
			return;
		}
		$store = new StoreFile($dir . DS . self::CONFIG_FILE);
		$store->save($data);
	}
	
}
