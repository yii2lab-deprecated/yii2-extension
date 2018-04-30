<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\InterfaceEntity;

class ClassRender extends BaseRender
{
	
	public function run() {
		$classEntity = $this->classEntity;
		$code = '';
		/** @var ClassEntity|InterfaceEntity $classEntity */
		$code .= $this->render(DocBlockRender::class);
		$code .= $this->renderHeader($classEntity);
		$code .= ' {' . PHP_EOL;
		$code .= $this->render(UseRender::class);
		$code .= $this->render(ConstantRender::class);
		$code .= $this->render(VariableRender::class);
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
	
	private static function renderHeader(ClassEntity $classEntity) {
		$code = '';
		if($classEntity->is_abstract) {
			$code .= ' abstract';
		}
		$code .= ' class ' . $classEntity->getName();
		if($classEntity->extends) {
			$code .= ' extends ' . $classEntity->extends;
		}
		if($classEntity->implements) {
			$code .= ' implements ' . $classEntity->implements;
		}
		$code = trim($code);
		return $code;
	}
}
