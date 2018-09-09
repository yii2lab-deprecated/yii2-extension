<?php

namespace yii2lab\extension\code\filters\parser;

use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\code\entities\TokenEntity;

class ToLine extends BaseScenario {
	
	public function depends() {
		return [
			RemoveComment::class,
		];
	}
	
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
				$entity->value = trim($entity->value);
				if($entity->type == T_WHITESPACE) {
					$entity->value = SPC;
				} elseif($entity->type == T_COMMENT && substr($entity->value, 0, 2) == '//') {
					$entity->value = $entity->value . PHP_EOL;
				}
				$newCollection[] = $entity;
			}
		}
		$this->setData($newCollection);
	}
	
	private function isNewLine(TokenEntity $entity) {
		return $entity->type == T_WHITESPACE;
	}
	
}
