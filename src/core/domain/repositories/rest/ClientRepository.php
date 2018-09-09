<?php

namespace yii2lab\extension\core\domain\repositories\rest;

use Yii;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use yii\web\ServerErrorHttpException;
use yii2lab\domain\repositories\BaseApiRepository;

/**
 * Class ClientRepository
 *
 * @package yii2lab\extension\core\domain\repositories\rest
 *
 * @deprecated
 */
class ClientRepository extends BaseApiRepository {
	
	public function getBaseUrl() {
		$baseUrl = env('servers.core.domain');
		if(YII_ENV_TEST) {
			$baseUrl .= 'index-test.php/';
		}
		return trim($baseUrl, SL);
	}
	
	protected function showServerException($response) {
		$exception = $response->data['type'];
		if(YII_DEBUG) {
			throw new $exception($response->data['message']);
		}
		parent::showServerException($response);
	}
	
	protected function showUserException($response) {
		$statusCode = $response->statusCode;
		if($statusCode == 422) {
			throw new UnprocessableEntityHttpException($response->data);
		}
		parent::showUserException($response);
	}
}
