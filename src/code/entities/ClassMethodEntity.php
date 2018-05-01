<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\Helper;
use yii2lab\extension\code\enums\AccessEnum;

/**
 * Class ClassMethodEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property string $access
 * @property boolean $is_static
 * @property boolean $is_abstract
 * @property boolean $is_final
 * @property ClassMethodParameterEntity[] $parameters
 */
class ClassMethodEntity extends BaseEntity {
	
	protected $name;
	protected $access = AccessEnum::PUBLIC;
	protected $is_static = false;
	protected $is_abstract = false;
	protected $is_final = false;
	protected $parameters = [];
	
	public function rules() {
		return [
			[['name','access'], 'required'],
			[['access'], 'in', 'range' => AccessEnum::values()],
		];
	}
	
	public function setParameters($value) {
		$this->parameters = Helper::forgeEntity($value, ClassMethodParameterEntity::class);
	}
}