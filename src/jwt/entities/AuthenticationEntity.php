<?php

namespace yii2lab\extension\jwt\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class AuthenticationEntity
 * 
 * @package yii2lab\extension\jwt\entities
 *
 * @property $login string
 * @property $password string
 * @property $type string
 */
class AuthenticationEntity extends BaseEntity {

    protected $login;
    protected $password;
    protected $type;

    public function rules() {
        return [
            [['login', 'password'], 'trim'],
            [['login', 'password'], 'required'],
        ];
    }

}
