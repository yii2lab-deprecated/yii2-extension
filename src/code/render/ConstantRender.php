<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;

/**
 * Class ConstantRender
 *
 * @package yii2lab\extension\code\render
 *
 * @property ClassEntity $entity
 */
class ConstantRender extends BaseRender
{
	
	public function run() {
		if($this->entity->constants == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->entity->constants);
		return $code;
	}
	
	protected function renderItem($constantEntity) {
		return TAB . 'const ' . $constantEntity->name . ' = ' . $constantEntity->value . ';' . PHP_EOL;
	}
}
