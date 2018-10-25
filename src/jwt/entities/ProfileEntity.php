<?php

namespace yii2lab\extension\jwt\entities;

use yii2lab\domain\BaseEntity;
use yii2lab\extension\enum\enums\TimeEnum;

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
    protected $life_time = TimeEnum::SECOND_PER_MINUTE * 20;
    protected $allowed_algs = ['HS256', 'SHA512', 'HS384', 'RS256'];
    protected $default_alg;
    protected $audience = [];
    protected $issuer_url;

    public function rules() {
        return [
            [['key', 'allowed_algs', 'default_alg'], 'required'],
        ];
    }

    public function getDefaultAlg() {
    	if(!empty($this->default_alg)) {
    		return $this->default_alg;
	    }
	    if(is_array($this->key)) {
		    return 'RS256';
	    }
	    if(is_string($this->key)) {
		    return 'HS256';
	    }
	    return null;
    }
    
}
