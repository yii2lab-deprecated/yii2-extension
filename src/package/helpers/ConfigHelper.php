<?php

namespace yii2lab\extension\package\helpers;

use yii2lab\app\domain\filters\env\LoadConfig;
use yii2lab\extension\store\StoreFile;
use yii2module\vendor\domain\helpers\GitShell;

class ConfigHelper {
	
	public static function addPackage(string $group, string $name) {
		$config = ConfigFileHelper::load(ROOT_DIR);
		$nn = "$group/yii2-$name";
		if(!isset($config['require'][$nn]) && !isset($config['require-dev'][$nn])) {
			$config['require'][$nn] = 'dev-master';
		}
		ConfigFileHelper::save(ROOT_DIR, $config);
		self::addPackageInAutoload($group, $name);
	}
	
	public static function addPackageInAutoload(string $group, string $name) {
		$store = new StoreFile(COMMON_DIR . DS . 'config' . DS . LoadConfig::FILE_ENV_SYSTEM_LOCAL . '.php');
		$cc = $store->load();
		$info = PackageHelper::generateAlias("$group/$name");
		$cc['aliases'][$info['name']] = $info['value'];
		$store->save($cc);
	}
	
	public static function load(string $group, string $name): array {
		$dir = PackageHelper::getDir($group, $name);
		return ConfigFileHelper::load($dir);
	}
	
	public static function save(string $group, string $name, array $data) {
		$dir = PackageHelper::getDir($group, $name);
		ConfigFileHelper::save($dir, $data);
	}
	
	public static function clone(string $group, string $name) {
		$dir = PackageHelper::getDir($group, $name);
		$git = new GitShell($dir);
		$git->clone("https://github.com/$group/yii2-$name.git");
	}
	
}
