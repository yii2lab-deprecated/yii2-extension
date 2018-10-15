<?php

namespace yii2lab\extension\scenario\base;

use yii\base\BaseObject;
use yii2lab\extension\scenario\interfaces\RunInterface;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii2lab\extension\scenario\helpers\ScenarioHelper;

class BaseStrategy extends BaseObject implements RunInterface {
	
	public $handlers = [];
	public $params;
	public $name;
	public $defaultName = null;
	
	public function run() {
		return $this->runHandler($this->name, $this->params);
	}
	
	protected function runHandler($type, $params) {
		$this->validate($type);
		$handlerDefinition = ArrayHelper::getValue($this->handlers, $type, $this->getDefaultDefinition());
		return ScenarioHelper::runHandler($handlerDefinition, $params);
	}
	
	protected function validate($type) {
		if(!isset($this->handlers[$type])) {
			throw new InvalidArgumentException('Handler "' . $type . '" not found in strategy "' . static::class . '"');
		}
	}
	
	protected function getDefaultDefinition() {
		if(empty($this->defaultName)) {
			return null;
		}
		if(!isset($this->handlers[$this->defaultName])) {
			return null;
		}
		return $this->handlers[$this->defaultName];
	}
	
}
