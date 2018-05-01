<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\Helper;

/**
 * Class CodeEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $fileName
 * @property string $fileExtension
 * @property string $namespace
 * @property ClassUseEntity[] $uses
 * @property string $code
 */
class CodeEntity extends BaseEntity {
	
	protected $fileName;
	protected $fileExtension = 'php';
	protected $namespace;
	protected $uses;
	protected $code;
	
	public function rules() {
		return [
			[['fileName'], 'required'],
		];
	}
	
	public function setUses($value) {
		$this->uses = Helper::forgeEntity($value, ClassUseEntity::class);
	}
}