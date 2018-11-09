<?php

namespace yii2lab\extension\core\services;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use yii2lab\domain\services\BaseService;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2lab\extension\web\enums\HttpMethodEnum;
use yii2lab\rest\domain\helpers\MiscHelper;
use yii2module\account\domain\v2\helpers\AuthHelper;

/**
 * Class ClientService
 * @package yii2lab\extension\core\services
 *
 * @deprecated
 */
class ClientService extends BaseService {
	
	public function send(RequestEntity $request) {
		try {
			$response = $this->repository->send($request);
		} catch(UnauthorizedHttpException $e) {
			\App::$domain->account->auth->breakSession();
		}
		return $response;
	}
	
	public function get($uri, $data = [], $headers = [], $version = 'v1') {
		return $this->runRequest(compact('uri', 'data', 'headers', 'version'), HttpMethodEnum::GET);
	}

	public function post($uri, $data = [], $headers = [], $version = 'v1') {
		return $this->runRequest(compact('uri', 'data', 'headers', 'version'), HttpMethodEnum::POST);
	}

	public function put($uri, $data = [], $headers = [], $version = 'v1') {
		return $this->runRequest(compact('uri', 'data', 'headers', 'version'), HttpMethodEnum::PUT);
	}

	public function delete($uri, $data = [], $headers = [], $version = 'v1') {
		return $this->runRequest(compact('uri', 'data', 'headers', 'version'), HttpMethodEnum::DELETE);
	}
	
	protected function getUri($uri, $version) {
		if(!MiscHelper::isValidVersion($version)) {
			throw new BadRequestHttpException('Bad API version');
		}
		return $version . SL . $uri;
	}
	
	protected function runRequest($data, $method) {
		$data['method'] = $method;
		$request = $this->forgeRequest($data);
		$response = $this->send($request);
		return $response;
	}
	
	protected function forgeRequest($data) {
		if(isset($data['uri']) && $data['uri'] instanceof RequestEntity) {
			return $data['uri'];
		} elseif(is_array($data['uri'])) {
			$data = $data['uri'];
		}
		
		$data['headers'] = $this->getHeaders($data['headers']);
		
		$data['uri'] = $this->getUri($data['uri'], $data['version']);
		$request = new RequestEntity;
		$request->load($data);
		return $request;
	}
	
	protected function getLanguage() {
		$language = Yii::$app->request->headers->get('Language');
		if(!empty($language)) {
			return $language;
		}
		return null;
	}
	
	protected function getHeaders($headers = []) {
		if(empty($headers['Authorization'])) {
			$authorization = AuthHelper::getTokenString();
			if(!empty($authorization)) {
				$headers['Authorization'] = $authorization;
			}
		}
		if(empty($headers['Language'])) {
			$language = $this->getLanguage();
			if(!empty($language)) {
				$headers['Language'] = $language;
			}
		}
		return $headers;
	}
	
}
