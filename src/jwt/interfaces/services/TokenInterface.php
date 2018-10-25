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

    public function sign(TokenEntity $tokenEntity, $profileName = 'default', $keyId = null, $head = null);
	
	/**
	 * @param        $token
	 * @param string $profileName
	 *
	 * @return TokenEntity
	 */
	public function decode($token, $profileName = 'default');
    public function decodeRaw($token, $profileName = 'default');
	
	/**
	 * @param        $subject
	 * @param string $profileName
	 * @param null   $keyId
	 * @param null   $head
	 *
	 * @return TokenEntity
	 */
    public function forgeBySubject($subject, $profileName = 'default', $keyId = null, $head = null);

    /**
     * @param $oldToken
     * @param AuthenticationEntity $authenticationEntity
     * @param $profileName
     * @return LoginEntity
     */
    public function authentication($oldToken, AuthenticationEntity $authenticationEntity, $profileName = 'default');

}
