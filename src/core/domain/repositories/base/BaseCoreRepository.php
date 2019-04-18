<?php

namespace yii2lab\extension\core\domain\repositories\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;
use yii2lab\extension\core\domain\helpers\CoreHelper;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use yii2lab\extension\web\helpers\ClientHelper;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2lab\rest\domain\entities\ResponseEntity;
use yii2lab\rest\domain\repositories\base\BaseRestRepository;

class BaseCoreRepository extends BaseRestRepository {

	public $version = null;
	public $point = EMP;

	public function init() {
		parent::init();
		$this->initVersion();
		$this->initBaseUrl();
//		$this->initHeaders();
	}

	protected function sendRequest(RequestEntity $requestEntity) {
		$headers = $requestEntity->headers;
		$headers[ClientHelper::IP_HEADER_KEY] = ClientHelper::getIpFromRequest();
		prr(ClientHelper::getIpFromRequest() . ' before',1,1);
		$requestEntity->headers = $headers;
		$responseEntity = parent::sendRequest($requestEntity);
		return $responseEntity;
	}

    protected function normalizeRequestEntity(RequestEntity $requestEntity) {
        $this->headers = ArrayHelper::merge($this->headers, CoreHelper::getHeaders());
        return parent::normalizeRequestEntity($requestEntity);
    }

	protected function showServerException(ResponseEntity $responseEntity) {
		$data = $responseEntity->data;
		$type = ArrayHelper::getValue($data, 'type');
		if(class_exists($type)) {
			$previous = new $type($data['message']);
			$previous = $previous instanceof \Exception ? $previous : null;
			throw new ServerErrorHttpException('Core Error' , 0, $previous);
		}
		if(is_array($data)) {
			throw new ServerErrorHttpException('Core Error: ' . $data['message'], 0);
		}else{
			throw new ServerErrorHttpException('Core Error: ' . 'Server return html response body with bug trace', 0);
		}
	}

	protected function showUserException(ResponseEntity $responseEntity) {
		$statusCode = $responseEntity->status_code;
		if($statusCode == 422) {
			throw new UnprocessableEntityHttpException($responseEntity->data);
		}
		if($statusCode == 401) {
			try {
				\App::$domain->account->auth->breakSession();
			} catch(UnauthorizedHttpException $e) {
				$message = ArrayHelper::getValue($responseEntity->data, 'message');
				throw new UnauthorizedHttpException($message);
			}
			return;
		}
		parent::showUserException($responseEntity);
	}

	private function initBaseUrl() {
		$this->baseUrl = CoreHelper::forgeUrl($this->version, $this->point);
	}

	/*private function initHeaders() {
		$this->headers = ArrayHelper::merge($this->headers, CoreHelper::getHeaders());
	}*/

    private function initVersion() {
	    if(empty($this->version)) {
		    $this->version = CoreHelper::defaultApiVersionNumber(1);
	    }
    }
}
