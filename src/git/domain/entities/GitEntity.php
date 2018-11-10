<?php

namespace yii2lab\extension\git\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class GitEntity
 * 
 * @package yii2lab\extension\git\domain\entities
 * 
 * @property $id
 * @property RemoteEntity[] $remotes
 * @property BranchEntity[] $branches
 */
class GitEntity extends BaseEntity {

	protected $id;
	protected $remotes;
	protected $branches;
	
	/*public function fieldType() {
		return [
			'remotes' => [
				'type' => RemoteEntity::class,
				'isCollection' => true,
			],
			'branches' => [
				'type' => BranchEntity::class,
				'isCollection' => true,
			],
		];
	}*/
}
