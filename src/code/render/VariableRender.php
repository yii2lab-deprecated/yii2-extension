<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\ClassVariableEntity;

/**
 * Class VariableRender
 *
 * @package yii2lab\extension\code\render
 *
 * @property ClassEntity $entity
 */
class VariableRender extends BaseRender
{
	
	public function run() {
		if($this->entity->variables == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->entity->variables);
		return $code;
	}
	
	protected function renderItem($variableEntity) {
		$header = $this->renderHeader($variableEntity);
		$code = TAB . $header;
		if(isset($variableEntity->value)) {
			$code .= ' = ' . $variableEntity->value;
		}
		$code .= ';' . PHP_EOL;
		return $code;
	}
	
	private function renderHeader(ClassVariableEntity $variableEntity) {
		$code = '';
		$code .= $variableEntity->access;
		if($variableEntity->is_static) {
			$code .= SPC . 'static';
		}
		$code .= SPC . '$' . $variableEntity->name;
		$code = trim($code);
		return $code;
	}
}
