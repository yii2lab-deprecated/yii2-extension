<?php

namespace yii2lab\extension\web\helpers;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii2lab\domain\services\base\BaseService;

class ControllerHelper {
	
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
		if($serviceName instanceof BaseService) {
			return $serviceName;
		} elseif(is_string($serviceName)) {
			return ArrayHelper::getValue(Yii::$domain, $serviceName);
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
