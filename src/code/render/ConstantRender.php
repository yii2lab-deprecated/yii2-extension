<?php

namespace yii2lab\extension\code\render;

class ConstantRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->constants == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($this->classEntity->constants as $constantEntity) {
			$code .= TAB . 'const ' . $constantEntity->name . ' = ' . $constantEntity->value . ';' . PHP_EOL;
		}
		return $code;
	}
	
}
