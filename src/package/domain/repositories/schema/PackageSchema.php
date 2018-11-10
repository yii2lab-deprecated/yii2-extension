<?php

namespace yii2lab\extension\package\domain\repositories\schema;

use yii2lab\domain\enums\RelationEnum;
use yii2lab\domain\repositories\relations\BaseSchema;

/**
 * Class PackageSchema
 * 
 * @package yii2lab\extension\package\domain\repositories\schema
 * 
 */
class PackageSchema extends BaseSchema {
	
	public function relations() {
		return [
			'group' => [
				'type' => RelationEnum::ONE,
				'field' => 'group_name',
				'foreign' => [
					'id' => 'package.group',
					'field' => 'name',
				],
			],
			'config' => [
				'type' => RelationEnum::ONE,
				'field' => 'dir',
				'foreign' => [
					'id' => 'package.config',
					'field' => 'dir',
				],
			],
			'git' => [
				'type' => RelationEnum::ONE,
				'field' => 'dir',
				'foreign' => [
					'id' => 'git.git',
					'field' => 'dir',
				],
			],
		];
	}
	
}
