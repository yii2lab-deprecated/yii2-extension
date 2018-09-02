<?php

namespace yii2lab\extension\jwt\interfaces\repositories;

use yii2lab\extension\jwt\entities\JwtEntity;
use yii2lab\extension\jwt\entities\ProfileEntity;

/**
 * Interface JwtInterface
 * 
 * @package yii2lab\extension\jwt\interfaces\repositories
 * 
 * @property-read \yii2lab\extension\jwt\Domain $domain
 */
interface JwtInterface {

    public function sign(JwtEntity $jwtEntity, ProfileEntity $profileEntity);
    public function encode(JwtEntity $jwtEntity, ProfileEntity $profileEntity);
    public function decode($token, ProfileEntity $profileEntity);

}
