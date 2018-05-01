<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassVariableEntity;

class VariableRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->variables == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->classEntity->variables);
		return $code;
	}
	
	protected function renderItem($variableEntity) {
		$header = $this->renderHeader($variableEntity);
		return TAB . $header . ' = ' . $variableEntity->value . ';' . PHP_EOL;
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
