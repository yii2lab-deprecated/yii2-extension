<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class DocBlockEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $title
 * @property string $description
 * @property DocBlockParameterEntity[] $parameters
 */
class DocBlockEntity extends BaseEntity {
	
	protected $title;
	protected $description;
	protected $parameters = [];
	
}