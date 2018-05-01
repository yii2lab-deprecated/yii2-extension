<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;
use yii2lab\extension\code\enums\AccessEnum;

/**
 * Class ClassVariableEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property string $access
 * @property boolean $is_static
 * @property mixed $value
 */
class ClassVariableEntity extends BaseEntity {
	
	protected $name;
	protected $access = AccessEnum::PUBLIC;
	protected $is_static = false;
	protected $value;
	
	public function rules() {
		return [
			[['name','access'], 'required'],
			[['access'], 'in', 'range' => AccessEnum::values()],
		];
	}
}