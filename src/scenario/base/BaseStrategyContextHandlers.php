<?php

namespace yii2lab\extension\scenario\base;

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
abstract class BaseStrategyContextHandlers extends BaseStrategyContext {
	
	private $handlers = [];
	
	public function getStrategyHandlers() {
		return $this->handlers;
	}
	
	public function setStrategyHandlers(array $handlers) {
		$this->handlers = $handlers;
	}
	
	public function setStrategyName(string $strategy) {
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
