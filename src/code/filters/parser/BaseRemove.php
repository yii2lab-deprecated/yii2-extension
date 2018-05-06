<?php

namespace yii2lab\extension\code\filters\parser;

use yii2lab\extension\code\entities\TokenEntity;

abstract class BaseRemove extends Base {
	
	protected $ignoreTypes = [];
	
	public function run() {
		/** @var TokenEntity[] $collection */
		$collection = $this->getData();
		foreach($collection as $k => &$entity) {
			if($this->isIgnore($entity)) {
				unset($collection[$k]);
			}
		}
		$this->setData($collection);
	}
	
	private function isIgnore(TokenEntity $entity) {
		return in_array($entity->type, $this->ignoreTypes);
	}
}
