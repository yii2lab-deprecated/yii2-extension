<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassMethodEntity;

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
		$head = $this->renderHeader($methodEntity);
		return TAB . $head . '() {' . PHP_EOL . PHP_EOL . TAB . '}' . PHP_EOL;
	}
	
	private function renderHeader(ClassMethodEntity $methodEntity) {
		$code = '';
		if($methodEntity->is_final) {
			$code .= SPC . 'final';
		}
		if($methodEntity->is_abstract) {
			$code .= SPC . 'abstract';
		}
		$code .= $methodEntity->access;
		if($methodEntity->is_static) {
			$code .= SPC . 'static';
		}
		$code .= SPC . 'function';
		$code .= SPC . $methodEntity->name;
		$code = trim($code);
		return $code;
	}
}
