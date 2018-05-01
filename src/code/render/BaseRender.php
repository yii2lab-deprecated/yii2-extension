<?php

namespace yii2lab\extension\code\render;

use yii2lab\designPattern\scenario\base\BaseScenario;

abstract class BaseRender extends BaseScenario
{
	
	public $entity;
	
	protected function renderItem($entity) {
	
	}
	
	protected function render($renderClass) {
		/** @var BaseRender $render */
		$render = new $renderClass();
		$render->entity = $this->entity;
		return $render->run();
	}
	
	protected function renderItems($items) {
		$code = '';
		foreach($items as $entity) {
			$code .= $this->renderItem($entity);
		}
		return $code;
	}
}
