<?php

namespace yii2lab\extension\common\helpers;

use Yii;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;
use yii2lab\extension\common\exceptions\ClassInstanceException;

class ComponentHelper {


	/**
	 * Detaches a behavior from the component.
	 * The behavior's [[Behavior::detach()]] method will be invoked.
	 * @param Component $instance
	 * @param string $behaviorClass the behavior's class.
	 * @return null|Behavior the detached behavior. Null if the behavior does not exist.
	 */
	public static function detachBehaviorByClass(Component $instance, $behaviorClass)
	{
		foreach ($instance->getBehaviors() as $key => $value) {
			if ($value instanceof $behaviorClass) {
				return $instance->detachBehavior($key);
			};
		}
		return null;
	}



}