<?php

namespace yii2lab\extension\package\helpers;

use Yii;
use yii2lab\app\domain\filters\env\LoadConfig;
use yii2lab\extension\store\StoreFile;
use yii2lab\extension\yii\helpers\ArrayHelper;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2module\vendor\domain\helpers\GitShell;

class ConfigHelper {
	
	public static function addPackage(string $group, string $name) {
		self::addPackageInProjectConfig($group, $name);
		self::addPackageInAutoload($group, $name);
	}
	
	public static function addPackageInProjectConfig(string $group, string $name) {
		$config = ConfigFileHelper::load(ROOT_DIR);
		$nn = "$group/yii2-$name";
		if(!isset($config['require'][$nn]) && !isset($config['require-dev'][$nn])) {
			$config['require'][$nn] = 'dev-master';
		}
		ConfigFileHelper::save(ROOT_DIR, $config);
	}
	
	private static function genAliasesFromPsr4(array $psrConfig, string $group, string $name) {
		$aliases = [];
		foreach($psrConfig as $key => $value) {
			$key = FileHelper::normalizeAlias($key);
			$key = trim($key, ' /');
			$aliases[$key] = "@vendor/$group/yii2-$name/$value";
		}
		return $aliases;
	}
	
	public static function addPackageInAutoload(string $group, string $name) {
		$store = new StoreFile(COMMON_DIR . DS . 'config' . DS . LoadConfig::FILE_ENV_SYSTEM_LOCAL . '.php');
		$allAliases = $store->load();
		$packageDir = PackageHelper::getDir($group, $name);
		$config = ConfigFileHelper::load($packageDir);
		$aliases = self::genAliasesFromPsr4($config['autoload']['psr-4'], $group, $name);
		$allAliases = ArrayHelper::merge($allAliases, $aliases);
		$store->save($allAliases);
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
