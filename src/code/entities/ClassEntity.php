<?php

namespace yii2lab\extension\code\entities;

use yii\helpers\Inflector;
use yii2lab\domain\BaseEntity;

/**
 * Class ClassEntity
 *
 * @package yii2lab\extension\code\entities
 *
 * @property string $name
 * @property boolean $is_abstract
 * @property string $extends
 * @property string $implements
 * @property-read string $namespace
 * @property-read string $alias
 * @property ClassUseEntity[] $uses
 * @property DocBlockEntity $doc_block
 * @property ClassVariableEntity[] $variables
 * @property ClassConstantEntity[] $constants
 * @property ClassMethodEntity[] $methods
 */
class ClassEntity extends BaseEntity {
	
	protected $name;
	protected $is_abstract = false;
	protected $extends;
	protected $implements;
	protected $uses = [];
	protected $doc_block = null;
	protected $variables = [];
	protected $constants = [];
	protected $methods = [];
	
	public function getName() {
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