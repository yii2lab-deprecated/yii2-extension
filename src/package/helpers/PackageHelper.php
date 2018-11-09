<?php

namespace yii2lab\extension\package\helpers;

use yii2lab\extension\package\domain\entities\PackageEntity;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2module\vendor\domain\helpers\GitShell;

class PackageHelper {
	
	public static function forge(string $group, string $name) {
		$dir = PackageHelper::getDir($group, $name);
		
		FileHelper::createDirectory($dir);
		$git = new GitShell($dir);
		
		if(!FileHelper::has($dir . DS . '.git')) {
			$git->clone("https://github.com/$group/yii2-$name.git");
		}
		
		ConfigHelper::addPackage($group, $name);
	}
	
	public static function getPackageTree(array $groups): array {
		$tree = [];
		foreach($groups as $group) {
			$tree[ $group ] = self::findPackagesInGroup($group);
		}
		return $tree;
	}
	
	public static function getPackageCollection(array $groups): array {
		$tree = PackageHelper::getPackageTree($groups);
		$collection = [];
		foreach($tree as $group => $packages) {
			foreach($packages as $package) {
				$packageEntity = new PackageEntity();
				$packageEntity->group_name = $group;
				$packageEntity->name = $package;
				$collection[] = $packageEntity;
			}
		}
		return $collection;
	}
	
	public static function findPackagesInGroup(string $group): array {
		$dir = "@vendor/$group";
		$dir = \Yii::getAlias($dir);
		$files = FileHelper::scanDir($dir);
		if(empty($files)) {
			return [];
		}
		return $files;
	}
	
	public static function getAlias(string $group, string $name = null, string $type = null) {
		$result = [];
		$result['group'] = "@vendor/$group";
		$result['direct'] = "@vendor/$group/yii2-$name";
		$result['short'] = "@vendor/$group/$name";
		if($type) {
			return $result[$type];
		}
		return $result;
	}
	
	public static function getDir(string $group, string $name = null): string {
		$alias = self::getAlias($group, $name, 'direct');
		return \Yii::getAlias($alias);
	}
	
	public static function generateAliases(array $packages): array {
		$aliases = [];
		foreach($packages as $package) {
			$info = self::generateAlias($package);
			$aliases[ $info['name'] ] = $info['value'];
		}
		return $aliases;
	}
	
	public static function generateAlias(string $package): array {
		$package = FileHelper::normalizePath($package, SL);
		list($groupName, $packageName) = explode(SL, $package);
		$result['name'] = "@{$groupName}/{$packageName}";
		$result['value'] = self::getAlias($groupName, $packageName, 'direct') . '/src';
		return $result;
	}
	
}
