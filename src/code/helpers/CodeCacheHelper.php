<?php

namespace yii2lab\extension\code\helpers;

use yii2lab\extension\develop\helpers\Benchmark;
use yii2lab\extension\store\StoreFile;
use yii2lab\extension\yii\helpers\FileHelper;

class CodeCacheHelper
{
	
	const CLASS_DEFINITION_ALIAS = 'common/runtime/cache/app/classes_code.php';
	const CLASS_DEFINED_ALIAS = 'common/data/code/classes.json';
	
	private static $excludeClasses = [
		'yii\BaseYii',
	];
	
	public static function saveDefinedClasses() {
		if(YII_ENV_PROD) {
			return;
		}
		$file = ROOT_DIR . DS . self::CLASS_DEFINED_ALIAS;
		$store = new StoreFile($file);
		$classesLoaded = $store->load();
		$classesLoaded = is_array($classesLoaded) ? $classesLoaded : [];
		$classes = ClassDeclaredHelper::allUserClasses();
		if($classesLoaded) {
			$classes = array_intersect($classes, $classesLoaded);
		}
		$store->save($classes);
		//CodeCacheHelper::saveClassesCache($classes);
		//CodeCacheHelper::loadClassesCache();
	}
	
	public static function loadClassesCache() {
		Benchmark::begin('load_classes_cache');
		$fileName = ROOT_DIR . DS . self::CLASS_DEFINITION_ALIAS;
		$store = new StoreFile($fileName);
		$files = $store->load();
		foreach($files as $className => $code) {
			self::evalCode($className, $code);
		}
		Benchmark::end('load_classes_cache');
	}
	
	private static function isExcludeClassName($className) {
		return in_array($className, self::$excludeClasses);
	}
	
	private static function evalCode($className, $code) {
		if(self::isExcludeClassName($className)) {
			return;
		}
		if(class_exists($className) || trait_exists($className) || interface_exists($className)) {
			return;
		}
		eval($code);
	}
	
	public static function saveClassesCache($classes) {
		$files = [];
		foreach($classes as $class) {
			if(!self::isExcludeClassName($class)) {
				$files[$class] = self::loadClassCode($class);
			}
		}
		$fileName = ROOT_DIR . DS . self::CLASS_DEFINITION_ALIAS;
		$store = new StoreFile($fileName);
		$store->save($files);
	}
	
	private static function loadClassCode($class) {
		$file = ClassHelper::classNameToFileName($class);
		$itemCode = FileHelper::load($file . DOT . 'php');
		$itemCode = preg_replace([
			'#^(\<\?php)#',
			'#^(\<\?)#',
			'#(\?\>)$#',
		], '', $itemCode);
		return $itemCode;
	}
	
}
