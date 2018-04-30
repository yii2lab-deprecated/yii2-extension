<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\InterfaceEntity;

class InterfaceRender extends BaseRender
{
	
	public function run() {
		$classEntity = $this->classEntity;
		$code = '';
		/** @var ClassEntity|InterfaceEntity $classEntity */
		$code .= $this->render(DocBlockRender::class);
		$code .= $this->renderHeader($classEntity);
		$code .= ' {' . PHP_EOL;
		$code .= $this->render(MethodRender::class);
		$code .=  '}';
		return $code;
	}
	
	private function render($renderClass) {
		/** @var BaseRender $render */
		$render = new $renderClass();
		$render->classEntity = $this->classEntity;
		return $render->run();
	}
	
	private static function renderHeader(InterfaceEntity $classEntity) {
		$code = '';
		$code .= ' interface ' . $classEntity->getName();
		if($classEntity->extends) {
			$code .= ' extends ' . $classEntity->extends;
		}
		$code = trim($code);
		return $code;
	}
}
