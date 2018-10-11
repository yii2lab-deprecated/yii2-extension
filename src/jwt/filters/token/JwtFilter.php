<?php

namespace yii2lab\extension\jwt\filters\token;

use yii\web\NotFoundHttpException;
use yii2lab\extension\yii\helpers\ArrayHelper;
use yii2module\account\domain\v2\entities\LoginEntity;
use yii2module\account\domain\v2\filters\token\BaseTokenFilter;

class JwtFilter extends BaseTokenFilter {

	public $profile = 'default';
	
	public function run() {
		try {
			$tokenEntity = \App::$domain->jwt->token->decode($this->token, $this->profile);
		} catch(\Exception $e) {
			throw new NotFoundHttpException('the_token_has_expired');
		}
		/** @var LoginEntity $loginEntity */
        $loginEntity = \App::$domain->account->login->oneById($tokenEntity->subject['id']);
        $token = ArrayHelper::getValue($tokenEntity, 'subject.token');
        if(!$token) {
	        $token = $this->token;
        }
		$loginEntity->token = $token;
        $this->setData($loginEntity);
	}
	
	public function auth($body, $ip) {
		$loginEntity = \App::$domain->account->repositories->auth->authentication($body['login'], $body['password'], $ip);
		$subject = [
			'id' => $loginEntity->id,
			'token' => $loginEntity->token,
			//'partner' => null,
		];
		$tokenEntity = \App::$domain->jwt->token->forgeBySubject($subject, $this->profile);
		$loginEntity->token = $this->forgeToken($tokenEntity->token);
		return $loginEntity;
	}

}
