<?php

namespace yii2lab\extension\code\helpers;

use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;

class ClassDeclaredHelper
{
	
	const TYPE_USER = 'user';
	const TYPE_SYSTEM = 'system';
	
	public static function allUserClasses() {
		$classes = self::getDeclaredArray();
		$classes = self::filter($classes);
		return $classes['user'];
	}
	
	private static function filter($all) {
		$result = [];
		foreach($all as $class) {
			try {
				ClassHelper::classNameToFileName($class);
				$result[self::TYPE_USER][] = $class;
			} catch(InvalidArgumentException $e) {
				$result[self::TYPE_SYSTEM][] = $class;
			}
		}
		return $result;
	}
	
	/*private static function filterTree($classes) {
		foreach($classes as &$class) {
			$class = self::filter($class);
		}
		return $classes;
	}*/
	
	private static function getDeclaredTree() {
		$classes['classes'] = get_declared_classes();
		$classes['traits'] = get_declared_traits();
		$classes['interfaces'] = get_declared_interfaces();
		return $classes;
	}
	
	private static function getDeclaredArray() {
		$classes = self::getDeclaredTree();
		$result = [];
		foreach($classes as $classList) {
			$result = ArrayHelper::merge($result, $classList);
		}
		return $result;
	}
	
}
