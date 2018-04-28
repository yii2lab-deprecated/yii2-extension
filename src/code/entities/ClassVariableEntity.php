<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class ClassVariableEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $access
 * @property boolean $is_static
 * @property mixed $value
 */
class ClassVariableEntity extends BaseEntity {
	
	const ACCESS_PUBLIC = 'public';
	
	protected $access = self::ACCESS_PUBLIC;
	protected $is_static = false;
	protected $value = null;
	
}