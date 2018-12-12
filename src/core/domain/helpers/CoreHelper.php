<?php

namespace yii2lab\extension\core\domain\helpers;

use Yii;
use yii\base\InvalidConfigException;
use yii2lab\extension\web\enums\HttpHeaderEnum;
use yii2module\account\domain\v2\helpers\AuthHelper;

class CoreHelper {
	
	public static function defaultApiVersionNumber($default = null) {
		$version = env('servers.core.defaultVersion', $default);
		if(empty($version)) {
			throw new InvalidConfigException('Undefined version in ' . self::class);
		}
		return $version;
	}

    public static function defaultApiVersionSting($default = null) {
        return 'v' . self::defaultApiVersionNumber($default);
    }
	
	public static function forgeUrl($version, $point = null) {
		$url = CoreHelper::getUrl($version);
		$point = trim($point, SL);
		if(!empty($point)) {
			$url .= SL . $point;
		}
		return $url;
	}
	
	public static function getUrl($version) {
		$url = self::getCoreDomain();
		if(YII_ENV_TEST) {
			$url .= SL . 'index-test.php';
		}
		$url .= SL . 'v' . $version;
		return $url;
	}
	
	public static function getHeaders() {
		$tokenDto = AuthHelper::getTokenDto();
		if($tokenDto) {
			$headers[HttpHeaderEnum::AUTHORIZATION] = AuthHelper::getTokenString();
		}
		$partnerTokenDto = \App::$domain->partner->auth->forgeAuthToken();
		if($partnerTokenDto) {
			$headers['Authorization-partner'] = $partnerTokenDto->getTokenString();
		}
		$headers[HttpHeaderEnum::LANGUAGE] = Yii::$app->language;
		$headers[HttpHeaderEnum::TIME_ZONE] = Yii::$app->timeZone;
		return $headers;
	}
	
	private static function getCoreDomain() {
		$domain = env('servers.core.domain');
		$domain = rtrim($domain, SL);
		return $domain;
	}
	
}
