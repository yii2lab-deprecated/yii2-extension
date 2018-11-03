<?php

namespace yii2lab\extension\common\helpers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;
use yii2lab\extension\common\exceptions\ClassInstanceException;

class InstanceHelper {
	
	public static function create($definition, $data, $interfaceClass = null) {
		$definition = ClassHelper::normalizeComponentConfig($definition);
		$handlerInstance = Yii::createObject($definition);
		if($interfaceClass) {
			ClassHelper::isInstanceOf($handlerInstance, $interfaceClass);
		}
		Yii::configure($handlerInstance, $data);
		return $handlerInstance;
	}
	
	public static function ensure($definition, $data = [], $interfaceClass = null) {
		if(is_object($definition)) {
			if($interfaceClass) {
				ClassHelper::isInstanceOf($definition, $interfaceClass);
			}
			return $definition;
		}
		return self::create($definition, $data, $interfaceClass);
	}
	
}