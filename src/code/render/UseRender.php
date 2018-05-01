<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\ClassUseEntity;

/**
 * Class UseRender
 *
 * @package yii2lab\extension\code\render
 *
 * @property ClassEntity $entity
 */
class UseRender extends BaseRender
{
	
	public function run() {
		if($this->entity->uses == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->entity->uses);
		return $code;
	}
	
	protected function renderItem($useEntity) {
		/** @var ClassUseEntity $useEntity */
		return TAB . 'use ' . $useEntity->name . ';' . PHP_EOL;
	}
}
