<?php

namespace yii2lab\extension\code\render;

class DocBlockRender extends BaseRender
{
	
	const LINE_START = '/**' . PHP_EOL;
	const LINE_END = ' */' . PHP_EOL;
	
	public function run() {
		$classEntity = $this->classEntity;
		if($classEntity->doc_block == null) {
			return EMP;
		}
		$code = '';
		$code .= self::LINE_START;
		$code .= $this->renderDocBlockLine($classEntity->doc_block->title);
		$code .= $this->renderDocBlockLine();
		$code .= $this->renderDocBlockLine('@package ' . $classEntity->namespace);
		$code .= $this->renderDocBlockLine();
		
		if($classEntity->doc_block->parameters != null) {
			foreach($classEntity->doc_block->parameters as $parameter) {
				$line = '@' . $parameter->name;
				if($parameter->type != null) {
					$line .= SPC . $parameter->type;
				}
				if($parameter->value != null) {
					$line .= SPC . '$' . $parameter->value;
				}
				$code .= $this->renderDocBlockLine($line);
			}
		}
		
		$code .= self::LINE_END;
		return $code;
	}
	
	private function renderDocBlockLine($text = EMP) {
		$code = ' * ' . $text . PHP_EOL;
		return $code;
	}
	
}
