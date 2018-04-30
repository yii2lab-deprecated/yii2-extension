<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\Helper;

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
	
	public function setParameters($value) {
		$this->parameters = Helper::forgeEntity($value, DocBlockParameterEntity::class);
	}
}