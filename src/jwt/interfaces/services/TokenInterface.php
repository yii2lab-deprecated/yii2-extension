<?php

namespace yii2lab\extension\jwt\interfaces\services;

use yii2lab\extension\jwt\entities\AuthenticationEntity;
use yii2lab\extension\jwt\entities\TokenEntity;
use yii2module\account\domain\v2\entities\LoginEntity;

/**
 * Interface TokenInterface
 * 
 * @package yii2lab\extension\jwt\interfaces\services
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\TokenInterface $repository
 */
interface TokenInterface {

    public function sign(TokenEntity $tokenEntity, $profileName = self::DEFAULT_PROFILE, $keyId = null, $head = null);

    /**
     * @param $token
     * @return TokenEntity
     */
    public function decode($token);
    public function decodeRaw($token, $profileName = self::DEFAULT_PROFILE);

    /**
     * @param $oldToken
     * @param AuthenticationEntity $authenticationEntity
     * @param $profileName
     * @return TokenEntity
     */
    public function forgeBySubject($subject, $profileName = self::DEFAULT_PROFILE);

    /**
     * @param $oldToken
     * @param AuthenticationEntity $authenticationEntity
     * @param $profileName
     * @return LoginEntity
     */
    public function authentication($oldToken, AuthenticationEntity $authenticationEntity, $profileName = self::DEFAULT_PROFILE);

}
