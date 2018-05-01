<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\InterfaceEntity;

class InterfaceRender extends BaseRender
{
	
	const LINE_START = ' {' . PHP_EOL;
	const LINE_END = PHP_EOL . '}';
	
	public function run() {
		$classEntity = $this->entity;
		$code = '';
		/** @var ClassEntity|InterfaceEntity $classEntity */
		$code .= $this->render(DocBlockRender::class);
		$code .= $this->renderHeader($classEntity);
		$code .= self::LINE_START;
		$code .= $this->render(MethodRender::class);
		$code .= self::LINE_END;
		return $code;
	}
	
	private static function renderHeader(InterfaceEntity $classEntity) {
		$code = 'interface ' . $classEntity->getName();
		if($classEntity->extends) {
			$code .= ' extends ' . $classEntity->extends;
		}
		$code = trim($code);
		return $code;
	}
}
