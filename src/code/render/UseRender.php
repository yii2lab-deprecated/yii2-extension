<?php

namespace yii2lab\extension\code\render;

class UseRender extends BaseRender
{
	
	public function run() {
		if($this->classEntity->uses == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($this->classEntity->uses as $useEntity) {
			$code .= TAB . 'use ' . $useEntity->name . ';' . PHP_EOL;
		}
		return $code;
	}
	
}
