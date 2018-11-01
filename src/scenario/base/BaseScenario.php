<?php

namespace yii2lab\extension\scenario\base;

use yii\base\BaseObject;
use yii2lab\extension\scenario\interfaces\RunInterface;

abstract class BaseScenario extends BaseObject implements RunInterface {
	
	private $data;
	public $event;
	public $isEnabled = true;
	
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
