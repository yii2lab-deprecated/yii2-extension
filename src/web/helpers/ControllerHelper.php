<?php

namespace yii2lab\extension\web\helpers;

use DateTimeZone;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii2lab\domain\events\DataEvent;
use yii2lab\domain\services\base\BaseService;
use yii2lab\extension\web\enums\HttpHeaderEnum;

class ControllerHelper {
	
	public static function runActionTrigger(Component $component, $eventName, $data) : DataEvent {
		$event = new DataEvent();
		$event->result = $data;
		$component->trigger($eventName, $event);
		return $event;
	}
	
	public static function setTimeZone() {
		$timeZone = Yii::$app->request->getHeaders()->get(HttpHeaderEnum::TIME_ZONE);
		if(!empty($timeZone)) {
			$listIdentifiers = DateTimeZone::listIdentifiers();
			if(!in_array($timeZone, $listIdentifiers)) {
				throw new BadRequestHttpException('Header "'.HttpHeaderEnum::TIME_ZONE.'" not valid!');
			}
			//Yii::$app->setTimeZone($timeZone);
		} else {
			$timeZone = Yii::$app->getTimeZone();
		}
		Yii::$app->response->getHeaders()->set(HttpHeaderEnum::TIME_ZONE, $timeZone);
		return $timeZone;
	}
	
	public static function runServiceMethod($service, $serviceMethod, $args, $serviceMethodParams = []) {
		$service = self::forgeService($service);
		$params = ControllerHelper::getServiceMethodParams($args, $serviceMethodParams);
		$response = call_user_func_array([$service, $serviceMethod], $params);
		return $response;
	}
	
	/**
	 * @param $serviceName
	 *
	 * @return null|BaseService
	 */
	public static function forgeService($serviceName) {
		if(empty($serviceName)) {
			return null;
		}
		if(is_object($serviceName)) {
			return $serviceName;
		} elseif(is_string($serviceName)) {
			return ArrayHelper::getValue(\App::$domain, $serviceName);
		}
		return null;
	}
	
	private static function getServiceMethodParams($args, $serviceMethodParams) {
		if(empty($serviceMethodParams)) {
			return $args;
		}
		if(!is_array($serviceMethodParams)) {
			throw new InvalidConfigException('The "serviceMethodParams" property should be array.');
		}
		$firstArg = $args[0];
		$params = [];
		foreach($serviceMethodParams as $paramName) {
			$params[] = ArrayHelper::getValue($firstArg, $paramName);
		}
		return $params;
	}
	
}
