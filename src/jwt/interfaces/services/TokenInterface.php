<?php

namespace yii2lab\extension\jwt\interfaces\services;

use yii2lab\extension\jwt\entities\TokenEntity;

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
    public function decode($token);
    public function decodeRaw($token, $profileName = self::DEFAULT_PROFILE);

}
