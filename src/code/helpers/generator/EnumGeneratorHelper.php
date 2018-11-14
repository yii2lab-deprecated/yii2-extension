<?php

namespace yii2lab\extension\code\helpers\generator;

use yii\helpers\ArrayHelper;

class EnumGeneratorHelper {
	
	private static $defaultConfig = [
		'use' => ['yii2lab\extension\enum\base\BaseEnum'],
		'afterClassName' => 'extends BaseEnum',
	];
	
	public static function generate($config) {
		$config = ArrayHelper::merge($config, self::$defaultConfig);
		ClassGeneratorHelper::generate($config);
	}
	
}
