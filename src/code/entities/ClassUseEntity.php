<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class ClassUseEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property string $as
 */
class ClassUseEntity extends BaseEntity {
	
	protected $name = null;
	protected $as = null;
	
	public function rules() {
		return [
			[['name'], 'required'],
		];
	}
}