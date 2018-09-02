<?php

namespace yii2lab\extension\jwt\interfaces\services;

use yii2lab\extension\jwt\entities\JwtEntity;

/**
 * Interface JwtInterface
 * 
 * @package yii2lab\extension\jwt\interfaces\services
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 * @property-read \yii2lab\extension\jwt\interfaces\repositories\JwtInterface $repository
 */
interface JwtInterface {

    public function sign(JwtEntity $jwtEntity, $profileName = self::DEFAULT_PROFILE);
    public function decode($token);

}
