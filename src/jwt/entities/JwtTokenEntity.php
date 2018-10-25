<?php

namespace yii2lab\extension\jwt\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class JwtTokenEntity
 * 
 * @package yii2lab\extension\jwt\entities
 *
 * @property $header array
 * @property $payload array
 * @property $sig string
 */
class JwtTokenEntity extends BaseEntity {

    protected $header;
    protected $payload;
    protected $sig;

}
