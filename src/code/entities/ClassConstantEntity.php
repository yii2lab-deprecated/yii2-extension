<?php

namespace yii2lab\extension\code\entities;

use yii\helpers\Inflector;
use yii2lab\domain\BaseEntity;

/**
 * Class ClassConstantEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property mixed $value
 */
class ClassConstantEntity extends BaseEntity {
	
	protected $name = null;
	protected $value = null;
	
	public function rules() {
		return [
			[['name','value'], 'required'],
		];
	}
	
	public function getName() {
		$underscore = Inflector::underscore($this->name);
		return strtoupper($underscore);
	}
	
}