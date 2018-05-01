<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

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
	
	const ACCESS_PUBLIC = 'public';
	const ACCESS_PROTECTED = 'protected';
	const ACCESS_PRIVATE = 'private';
	
	protected $name;
	protected $access = self::ACCESS_PUBLIC;
	protected $is_static = false;
	protected $value = null;
	
	public function getAccess() {
		if(!isset($this->access)) {
			return self::ACCESS_PUBLIC;
		}
		return $this->access;
	}
	
}