<?php

namespace yii2lab\extension\git\domain\entities;

use yii2lab\domain\BaseEntity;
use yii2mod\helpers\ArrayHelper;

/**
 * Class RefEntity
 * 
 * @package yii2lab\extension\git\domain\entities
 * 
 * @property $hash
 * @property $value
 * @property $type
 * @property $name
 */
class RefEntity extends BaseEntity {

	protected $hash;
	protected $value;
	protected $type;
	protected $name;
	
	public function getType() {
		$values = explode(SL, $this->value);
		$typeArray = array_slice($values, 1, -1);
		return implode(SL, $typeArray);
	}
	
	public function getName() {
		$values = explode(SL, $this->value);
		$name = ArrayHelper::last($values);
		$name = trim($name, '^{}');
		return $name;
	}

}
