<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class ClassMethodParameterEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $type
 * @property string $name
 * @property mixed $value
 */
class ClassMethodParameterEntity extends BaseEntity {
	
	protected $name;
	protected $type;
	protected $value;
	
	public function rules() {
		return [
			[['name'], 'required'],
		];
	}
}