<?php

namespace yii2lab\extension\time\components;

use yii\validators\Validator;
use yii2lab\extension\web\helpers\ControllerHelper;

class TimeComponent extends Validator {
	
	public function init() {
		$timeZone = ControllerHelper::setTimeZone();
		if($timeZone != \Yii::$app->timeZone) {
			\Yii::$app->timeZone = $timeZone;
		}
		if(APP == API) {
			prr(date('H:i:s', time()),1,1);
		}
		parent::init();
	}
	
}
