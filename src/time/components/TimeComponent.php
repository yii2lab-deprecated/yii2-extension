<?php

namespace yii2lab\extension\time\components;

use Yii;
use yii\base\Component;
use DateTimeZone;
use yii\web\BadRequestHttpException;
use yii2lab\extension\web\enums\HttpHeaderEnum;

class TimeComponent extends Component {
	
	public function init() {
		if(APP == API) {
			$timeZone = $this->getTimeZone();
			if($timeZone != Yii::$app->timeZone) {
				Yii::$app->timeZone = $timeZone;
			}
			Yii::$app->response->headers->set(HttpHeaderEnum::TIME_ZONE, $timeZone);
		}
	}
	
	private function getTimeZone() {
		if( ! Yii::$app->request->headers->has(HttpHeaderEnum::TIME_ZONE)) {
			return Yii::$app->timeZone;
		}
		$timeZone = Yii::$app->request->headers->get(HttpHeaderEnum::TIME_ZONE);
		$this->validateVal($timeZone);
		return $timeZone;
	}
	
	private function validateVal($timeZone) {
		$listIdentifiers = DateTimeZone::listIdentifiers();
		if(!in_array($timeZone, $listIdentifiers)) {
			throw new BadRequestHttpException('Header "'.HttpHeaderEnum::TIME_ZONE.'" not valid!');
		}
	}
}
