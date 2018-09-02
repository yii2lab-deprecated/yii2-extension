<?php

namespace yii2lab\extension\jwt\entities;

use yii2lab\app\domain\helpers\EnvService;
use yii2lab\domain\BaseEntity;
use yii2lab\helpers\StringHelper;

/**
 * Class JwtEntity
 *
 * @package yii2lab\extension\jwt\entities
 *
 * property $id integer
 * @property $token string
 * @property $issuer_url string iss: чувствительная к регистру строка или URI, которая является уникальным идентификатором стороны, генерирующим токен
 * @property $subject array|\Object
 * @property $subject_url string sub: чувствительная к регистру строка или URI, которая является уникальным идентификатором стороны, о которой содержится информация в данном токене. Значения с этим ключом должны быть уникальны в контексте стороны, генерирующей JWT.
 * @property $audience string[] aud: массив чувствительных к регистру строк или URI, являющийся списком получателей данного токена. Когда принимающая сторона получает JWT с данным ключом, она должна проверить наличие себя в получателях — иначе проигнорировать токен
 * @property $expire_at integer exp: время в формате Unix Time, определяющее момент, когда токен станет не валидным
 * @property $begin_at integer nbf: в противоположность ключу exp, это время в формате Unix Time, определяющее момент, когда токен станет валидным
 */
class JwtEntity extends BaseEntity {
	
	//protected $id;
    protected $token;
	protected $issuer_url;
	protected $subject;
	protected $subject_url;
	protected $audience = [];
	protected $expire_at;
	protected $begin_at;

    /*public function getSubjectUrl() {
        if($this->subject_url) {
            return $this->subject_url;
        }
        if(empty($this->subject_id)) {
            return null;
        }
        return EnvService::getUrl(API, 'v1/user/' . $this->subject_id);
    }

	public function getId() {
	    if($this->id) {
	        return $this->id;
        }
        return StringHelper::genUuid();
    }*/

}
