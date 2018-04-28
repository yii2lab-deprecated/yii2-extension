<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class DocBlockParameterEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property mixed $value
 */
class DocBlockParameterEntity extends BaseEntity {
	
	const NAME_PROPERTY = 'PROPERTY';
	const NAME_DEPRECATED = 'DEPRECATED';
	
	protected $name;
	protected $value;
	
}