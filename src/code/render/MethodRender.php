<?php

namespace yii2lab\extension\code\render;

class MethodRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->methods == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($this->classEntity->methods as $methodEntity) {
			$code .= TAB . 'function ' . $methodEntity->name . '() {' . PHP_EOL . PHP_EOL . TAB . '}' . PHP_EOL . PHP_EOL;
		}
		return $code;
	}
	
}
