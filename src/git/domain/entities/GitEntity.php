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
 * @property TagEntity[] $tags
 * @property RefEntity[] $refs
 * @property $local_head
 * @property $orig_head
 */
class GitEntity extends BaseEntity {

	protected $id;
	protected $remotes;
	protected $branches;
	protected $refs;
	protected $tags;
	protected $local_head;
	protected $orig_head;
	
	public function fieldType() {
		return [
			'remotes' => [
				'type' => RemoteEntity::class,
				'isCollection' => true,
			],
			'branches' => [
				'type' => BranchEntity::class,
				'isCollection' => true,
			],
			'refs' => [
				'type' => RefEntity::class,
				'isCollection' => true,
			],
		];
	}
}
