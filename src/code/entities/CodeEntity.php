<?php

namespace yii2lab\extension\code\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class CodeEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property ClassUseEntity[] $uses
 * @property string $code
 */
class CodeEntity extends BaseEntity {
	
	protected $uses;
	protected $code;
	
}