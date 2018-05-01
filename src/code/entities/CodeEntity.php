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
 * @property string $namespace
 * @property ClassUseEntity[] $uses
 * @property string $code
 */
class CodeEntity extends BaseEntity {
	
	protected $fileName;
	protected $namespace;
	protected $uses;
	protected $code;
	
	public function setUses($value) {
		$this->uses = Helper::forgeEntity($value, ClassUseEntity::class);
	}
}