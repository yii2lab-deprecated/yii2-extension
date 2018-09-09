<?php

namespace yii2lab\extension\code\entities;

use yii\helpers\Inflector;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\Helper;
use yii2lab\extension\yii\helpers\FileHelper;

/**
 * Class ClassEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property string $extends
 * @property DocBlockEntity $doc_block
 * @property ClassMethodEntity[] $methods
 */
class InterfaceEntity extends BaseEntity {
	
	protected $name;
	protected $extends;
	protected $doc_block = null;
	protected $methods = [];
	
	public function rules() {
		return [
			[['name'], 'required'],
		];
	}
	
	public function setDocBlock($value) {
		$this->doc_block = Helper::forgeEntity($value, DocBlockEntity::class);
	}
	
	public function setMethods($value) {
		$this->methods = Helper::forgeEntity($value, ClassMethodEntity::class);
	}
	
	public function fieldType() {
		return [
			'doc_block' => DocBlockEntity::class,
		];
	}
	
	public function getName() {
		$this->name= FileHelper::normalizePath($this->name);
		$basename = basename($this->name);
		return ucfirst(Inflector::camelize($basename));
	}
	
	public function getNamespace() {
		return dirname($this->name);
	}
	
	public function getAlias() {
		$namespace = $this->getNamespace();
		$namespace = str_replace('\\', SL, $namespace);
		$namespace = '@' . $namespace;
		return $namespace;
	}
	
}