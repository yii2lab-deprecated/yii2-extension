<?php

namespace yii2lab\extension\git\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class BranchEntity
 * 
 * @package yii2lab\extension\git\domain\entities
 * 
 * @property $name
 * @property $remote
 * @property $merge
 */
class BranchEntity extends BaseEntity {

	protected $name;
	protected $remote;
	protected $merge;

}
