<?php

namespace yii2lab\extension\code\filters\parser;

use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\code\entities\TokenEntity;

class RemoveDoubleEmptyLines extends BaseScenario {
	
	public function run() {
		/** @var TokenEntity[] $collection */
		$collection = $this->getData();
		$collection = array_values($collection);
		$newCollection = [];
		foreach($collection as $k => $entity) {
			$isNewLinePrev = isset($collection[$k-1]) && $this->isNewLine($collection[$k-1]);
			$isNewLineCurrent = isset($collection[$k]) && $this->isNewLine($collection[$k]);
			if($isNewLinePrev && $isNewLineCurrent) {
			
			} else {
				$newCollection[] = $entity;
			}
		}
		$this->setData($newCollection);
	}
	
	private function isNewLine(TokenEntity $entity) {
		$value = $entity->value;
		$hasEol = strpos($value, PHP_EOL) !== false;
		return $entity->type == T_WHITESPACE && $hasEol;
	}
	
}
