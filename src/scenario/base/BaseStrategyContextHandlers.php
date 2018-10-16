<?php

namespace yii2lab\extension\scenario\base;

use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;

/**
 * Class BaseStrategyContext
 *
 * @package yii2lab\extension\scenario\base
 *
 * @property-read Object  $strategyInstance
 * @property-read array   $strategyDefinitions
 * @property-write string $strategyName
 */
abstract class BaseStrategyContextHandlers extends BaseStrategyContext {
	
	private $strategyDefinitions = [];
	
	public function getStrategyDefinitions() {
		return $this->strategyDefinitions;
	}
	
	public function setStrategyDefinitions(array $handlers) {
		$this->strategyDefinitions = $handlers;
	}
	
	public function setStrategyName(string $strategyName) {
		$this->validate($strategyName);
		$strategyDefinition = ArrayHelper::getValue($this->getStrategyDefinitions(), $strategyName);
		$this->setStrategyDefinition($strategyDefinition);
	}
	
	protected function validate($name) {
		$strategyHandlers = $this->getStrategyDefinitions();
		if(empty($strategyHandlers)) {
			throw new InvalidArgumentException('Strategy handlers not defined!');
		}
		if(!isset($strategyHandlers[$name])) {
			throw new InvalidArgumentException('Handler "' . $name . '" not found!');
		}
	}
	
}
