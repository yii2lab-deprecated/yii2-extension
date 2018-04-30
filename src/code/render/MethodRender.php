<?php

namespace yii2lab\extension\code\render;

class MethodRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->methods == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->classEntity->methods);
		return $code;
	}
	
	protected function renderItem($methodEntity) {
		return TAB . 'function ' . $methodEntity->name . '() {' . PHP_EOL . PHP_EOL . TAB . '}' . PHP_EOL . PHP_EOL;
	}
}
