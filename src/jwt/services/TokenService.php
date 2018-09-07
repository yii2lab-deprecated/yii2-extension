<?php

namespace yii2lab\extension\jwt\services;

use yii2lab\extension\jwt\entities\TokenEntity;
use yii2lab\extension\jwt\interfaces\services\TokenInterface;
use yii2lab\domain\services\base\BaseService;
use yii2lab\helpers\StringHelper;

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

    private function getProfile($name) {
        $profileEntity = $this->domain->profile->oneById($name);
        $profileEntity->validate();
        return $profileEntity;
    }

    public function sign(TokenEntity $jwtEntity, $profileName = self::DEFAULT_PROFILE, $keyId = null, $head = null) {
        $profileEntity = $this->getProfile($profileName);
        $keyId = $keyId ?  : StringHelper::genUuid();
        $this->repository->sign($jwtEntity, $profileEntity, $keyId, $head);
        return $jwtEntity;
    }

    public function decode($token, $profileName = self::DEFAULT_PROFILE) {
        $profileEntity = $this->getProfile($profileName);
        $jwtEntity = $this->repository->decode($token, $profileEntity);
        $jwtEntity->token = $token;
        return $jwtEntity;
    }

    public function decodeRaw($token, $profileName = self::DEFAULT_PROFILE) {
        $profileEntity = $this->getProfile($profileName);
        return $this->repository->decodeRaw($token, $profileEntity);
    }

}
