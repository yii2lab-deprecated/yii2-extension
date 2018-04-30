<?php

namespace yii2lab\extension\code\render;

class ConstantRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->constants == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->classEntity->constants);
		return $code;
	}
	
	protected function renderItem($constantEntity) {
		return TAB . 'const ' . $constantEntity->name . ' = ' . $constantEntity->value . ';' . PHP_EOL;
	}
}
