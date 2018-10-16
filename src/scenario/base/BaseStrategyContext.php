<?php

namespace yii2lab\extension\scenario\base;

use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii2lab\extension\common\helpers\ClassHelper;

/**
 * Class BaseStrategyContext
 *
 * @package yii2lab\extension\scenario\base
 *
 * @property-read Object $strategyInstance
 * @property-read array $strategyHandlers
 * @property-write string $strategyName
 */
class BaseStrategyContext extends BaseObject {
	
	private $handlers = [];
	private $strategyInstance;
	
	public function getStrategyHandlers() {
		return $this->handlers;
	}
	
	public function setStrategyHandlers($handlers) {
		$this->handlers = $handlers;
	}
	
	public function getStrategyInstance() {
		return $this->strategyInstance;
	}
	
	public function setStrategyInstance($strategyInstance) {
		$this->strategyInstance = $strategyInstance;
	}
	
	public function setStrategyName($strategy) {
		$this->validate($strategy);
		$handlerDefinition = ArrayHelper::getValue($this->getStrategyHandlers(), $strategy);
		$instance = ClassHelper::createInstance($handlerDefinition, []);
		$this->setStrategyInstance($instance);
	}
	
	protected function validate($name) {
		$strategyHandlers = $this->getStrategyHandlers();
		if(empty($strategyHandlers)) {
			throw new InvalidArgumentException('Strategy handlers not defined!');
		}
		if(!isset($strategyHandlers[$name])) {
			throw new InvalidArgumentException('Handler "' . $name . '" not found!');
		}
	}
	
}
