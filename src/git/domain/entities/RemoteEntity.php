<?php

namespace yii2lab\extension\git\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class RemoteEntity
 * 
 * @package yii2lab\extension\git\domain\entities
 * 
 * @property $name
 * @property $url
 * @property $fetch
 * @property $pushurl
 */
class RemoteEntity extends BaseEntity {

	protected $name;
	protected $url;
	protected $fetch;
	protected $pushurl;

}
