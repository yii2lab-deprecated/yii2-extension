<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\ClassEntity;

/**
 * Class DocBlockRender
 *
 * @package yii2lab\extension\code\render
 *
 * @property ClassEntity $entity
 */
class DocBlockRender extends BaseRender
{
	
	const LINE_START = '/**' . PHP_EOL;
	const LINE_END = ' */' . PHP_EOL;
	
	public function run() {
		$classEntity = $this->entity;
		if($classEntity->doc_block == null) {
			return EMP;
		}
		$code = self::LINE_START;
		$code .= $this->renderItemText($classEntity->doc_block->title);
		$code .= $this->renderItemText();
		$code .= $this->renderItemText('@package ' . $classEntity->namespace);
		$code .= $this->renderItemText();
		$code .= $this->renderParameters();
		$code .= self::LINE_END;
		return $code;
	}
	
	private function renderItemText($text = EMP) {
		$code = ' * ' . $text . PHP_EOL;
		return $code;
	}
	
	private function renderParameters() {
		$classEntity = $this->entity;
		if($classEntity->doc_block->parameters == null) {
			return EMP;
		}
		$code = '';
		foreach($classEntity->doc_block->parameters as $parameter) {
			$line = '@' . $parameter->name;
			if($parameter->type != null) {
				$line .= SPC . $parameter->type;
			}
			if($parameter->value != null) {
				$line .= SPC . '$' . $parameter->value;
			}
			$code .= $this->renderItemText($line);
		}
		return $code;
	}
}
