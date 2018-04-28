<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class ClassMethodEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property string $access
 * @property boolean $is_static
 * @property boolean $is_abstract
 * @property ClassMethodParameterEntity[] $parameters
 */
class ClassMethodEntity extends BaseEntity {
	
	const ACCESS_PUBLIC = 'public';
	
	protected $name;
	protected $access = self::ACCESS_PUBLIC;
	protected $is_static = false;
	protected $is_abstract = false;
	protected $parameters = [];
	
}