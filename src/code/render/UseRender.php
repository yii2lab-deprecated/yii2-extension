<?php

namespace yii2lab\extension\code\render;

class UseRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->uses == null) {
			return EMP;
		}
		$code = PHP_EOL;
		$code .= $this->renderItems($this->classEntity->uses);
		return $code;
	}
	
	protected function renderItem($useEntity) {
		return TAB . 'use ' . $useEntity->name . ';' . PHP_EOL;
	}
}
