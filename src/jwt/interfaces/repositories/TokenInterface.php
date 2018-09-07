<?php

namespace yii2lab\extension\jwt\interfaces\repositories;

use yii2lab\extension\jwt\entities\ProfileEntity;
use yii2lab\extension\jwt\entities\TokenEntity;

/**
 * Interface TokenInterface
 * 
 * @package yii2lab\extension\jwt\interfaces\repositories
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 */
interface TokenInterface {

    public function sign(TokenEntity $jwtEntity, ProfileEntity $profileEntity, $keyId = null, $head = null);
    public function encode(TokenEntity $jwtEntity, ProfileEntity $profileEntity);
    public function decode($token, ProfileEntity $profileEntity);

}
