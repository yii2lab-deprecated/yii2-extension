<?php

namespace yii2lab\extension\jwt\services;

use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii2lab\extension\jwt\entities\AuthenticationEntity;
use yii2lab\extension\jwt\entities\ProfileEntity;
use yii2lab\extension\jwt\entities\TokenEntity;
use yii2lab\extension\jwt\interfaces\services\TokenInterface;
use yii2lab\domain\services\base\BaseService;
use yii2lab\extension\web\enums\HttpMethodEnum;
use yii2lab\extension\common\helpers\StringHelper;
use yii2lab\rest\domain\entities\RequestEntity;
use yii2lab\rest\domain\helpers\RestHelper;

/**
 * Class TokenService
 * 
 * @package yii2lab\extension\jwt\services
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\TokenInterface $repository
 */
class TokenService extends BaseService implements TokenInterface {

    const DEFAULT_PROFILE = 'default';

    public function sign(TokenEntity $tokenEntity, $profileName = self::DEFAULT_PROFILE, $keyId = null, $head = null) {
        $profileEntity = $this->getProfile($profileName);
        $keyId = $keyId ?  : StringHelper::genUuid();
        $this->prepEntity($tokenEntity, $profileEntity);
        $this->repository->sign($tokenEntity, $profileEntity, $keyId, $head);
        return $tokenEntity;
    }

    public function decode($token, $profileName = self::DEFAULT_PROFILE) {
        $profileEntity = $this->getProfile($profileName);
        $tokenEntity = $this->repository->decode($token, $profileEntity);
        $tokenEntity->token = $token;
        return $tokenEntity;
    }

    public function decodeRaw($token, $profileName = self::DEFAULT_PROFILE) {
        $profileEntity = $this->getProfile($profileName);
        return $this->repository->decodeRaw($token, $profileEntity);
    }

    public function forgeBySubject($subject, $profileName = self::DEFAULT_PROFILE, $keyId = null, $head = null) {
        $profileEntity = $this->getProfile($profileName);
        $tokenEntity = new TokenEntity();
        $tokenEntity->subject = $subject;
        \App::$domain->jwt->token->sign($tokenEntity, $profileName, $keyId, $head);
        return $tokenEntity;
    }

    public function authentication($oldToken, AuthenticationEntity $authenticationEntity, $profileName = self::DEFAULT_PROFILE) {
        $authenticationEntity->validate();
        $authenticationEntity->type = 'jwt';
        $tokenData = $this->decodeRaw($oldToken, $profileName);
        $tokenEntity = $this->repository->forgeEntity($tokenData->payload);
        $requestEntity = new RequestEntity();
        $requestEntity->uri = $tokenEntity->issuer_url;
        $requestEntity->method = HttpMethodEnum::POST;
        $requestEntity->data = $authenticationEntity->toArray();
        $responseEntity = RestHelper::sendRequest($requestEntity);
        return $responseEntity;
    }

    /*public function forge(, $profileName = self::DEFAULT_PROFILE) {

    }*/

    private function prepEntity(TokenEntity $tokenEntity, ProfileEntity $profileEntity) {
        if(!$tokenEntity->issuer_url && $profileEntity->issuer_url) {
            $tokenEntity->issuer_url = $profileEntity->issuer_url;
            //$tokenEntity->issuer_url = EnvService::getUrl(API, 'v1/auth');
        }
        /*$userId = ArrayHelper::getValue($tokenEntity, 'subject.id');
        if($userId) {
            if(!$tokenEntity->subject_url) {
                $tokenEntity->subject_url = EnvService::getUrl(API, 'v1/user/' . $userId);
            }
        }*/
    }

    private function getProfile($name) {
	    /** @var ProfileEntity $profileEntity */
	    try {
		    $profileEntity = $this->domain->profile->oneById($name);
	    } catch(NotFoundHttpException $e) {
	    	throw new InvalidArgumentException('Profile "' . $name . '" not defined!');
	    }
        $profileEntity->validate();
        return $profileEntity;
    }

}
