<?php

namespace yii2lab\extension\git\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class TagEntity
 * 
 * @package yii2lab\extension\git\domain\entities
 * 
 * @property $name
 * @property $hash
 */
class TagEntity extends BaseEntity {

	protected $name;
	protected $hash;

}
