<?php

namespace yii2lab\extension\time\components;

use yii\validators\Validator;
use yii2lab\extension\web\helpers\ControllerHelper;

class TimeComponent extends Validator {
	
	public function init() {
		if(APP == CONSOLE) {
			return;
		}
		$timeZone = ControllerHelper::setTimeZone();
		if($timeZone != \Yii::$app->timeZone) {
			\Yii::$app->timeZone = $timeZone;
		}
		parent::init();
	}
	
}
