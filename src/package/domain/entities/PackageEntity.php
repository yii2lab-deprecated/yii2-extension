<?php

namespace yii2lab\extension\package\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class PackageEntity
 * 
 * @package yii2lab\extension\package\domain\entities
 * 
 * @property $id
 * @property $name
 * @property $group_name
 * @property $group
 */
class PackageEntity extends BaseEntity {

	protected $id;
	protected $name;
	protected $group_name;
	protected $group;

	public function getId() {
		return $this->group_name . SL . $this->name;
	}
	
	public function fieldType() {
		return [
			'group' => GroupEntity::class,
		];
	}
	
}
