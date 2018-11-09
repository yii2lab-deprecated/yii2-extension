<?php

namespace yii2lab\extension\package\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class PackageEntity
 * 
 * @package yii2lab\extension\package\domain\entities
 * 
 * @property $id
 * @property $group
 * @property $name
 */
class PackageEntity extends BaseEntity {

	protected $id;
	protected $group;
	protected $name;

	public function getId() {
		return $this->group . SL . $this->name;
	}
	
}
