<?php

namespace yii2lab\extension\code\render;

class VariableRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->variables == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($this->classEntity->variables as $variableEntity) {
			$code .= TAB . 'var $' . $variableEntity->name . ' = ' . $variableEntity->value . ';' . PHP_EOL;
		}
		return $code;
	}
	
}
