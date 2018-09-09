<?php

namespace yii2lab\extension\scenario\base;

use yii\base\BaseObject;

abstract class BaseScenario extends BaseObject {
	
	private $data;
	public $isEnabled = true;
	
	abstract public function run();
	
	public function isEnabled() {
		return $this->isEnabled;
	}
	
	public function setData($value) {
		$this->data = $value;
	}
	
	public function issetData() {
		return isset($this->data);
	}
	
	public function getData() {
		return $this->data;
	}
	
}
