<?php

namespace yii2lab\extension\jwt\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class JwtProfileEntity
 *
 * @package yii2lab\extension\jwt\entities
 *
 * @property $name string
 * @property $key string
 * @property $life_time integer
 * @property $allowed_algs string[]
 * @property $default_alg string
 * @property $audience string[]
 * @property $issuer_url string
 */
class ProfileEntity extends BaseEntity {

    protected $name;
    protected $key;
    protected $life_time;
    protected $allowed_algs = [];
    protected $default_alg;
    protected $audience = [];
    protected $issuer_url;

    public function rules() {
        return [
            [['key', 'allowed_algs', 'default_alg'], 'required'],
        ];
    }

}
