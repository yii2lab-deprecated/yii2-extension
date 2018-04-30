<?php

namespace yii2lab\extension\code\render;

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
	
	protected function renderItem($useEntity) {
		return TAB . 'var $' . $useEntity->name . ' = ' . $useEntity->value . ';' . PHP_EOL;
	}
	
}
