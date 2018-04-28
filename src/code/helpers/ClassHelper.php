<?php

namespace yii2lab\extension\code\helpers;

use yii2lab\extension\code\entities\ClassEntity;

/**
 * Class ClassHelper
 *
 * @package yii2lab\extension\code\helpers
 */
class ClassHelper
{

	public static function render(ClassEntity $classEntity) {
		$code = '';
		$code .= static::renderDocBlock($classEntity);
		$code .= static::renderHeader($classEntity);
		$code .= ' { ' . PHP_EOL;
		$code .= static::renderUses($classEntity);
		$code .= static::renderConstants($classEntity);
		$code .= static::renderVariables($classEntity);
		$code .= static::renderMethods($classEntity);
		$code .=  PHP_EOL . ' }';
		return $code;
	}
	
	private static function renderUses(ClassEntity $classEntity) {
		if($classEntity->uses == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->uses as $useEntity) {
			$code .= TAB . 'use ' . $useEntity->name . ';' . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderConstants(ClassEntity $classEntity) {
		if($classEntity->constants == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->constants as $constantEntity) {
			$code .= TAB . 'const ' . $constantEntity->name . ' = ' . $constantEntity->value . ';' . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderVariables(ClassEntity $classEntity) {
		if($classEntity->variables == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->variables as $variableEntity) {
			$code .= TAB . 'var ' . $variableEntity->name . ' = ' . $variableEntity->value . ';' . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderMethods(ClassEntity $classEntity) {
		if($classEntity->methods == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->methods as $methodEntity) {
			$code .= TAB . 'function ' . $methodEntity->name . '() {' . PHP_EOL . PHP_EOL . TAB . '}' . PHP_EOL . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderDocBlock(ClassEntity $classEntity) {
		if($classEntity->doc_block == null) {
			return EMP;
		}
		$code = '';
		$code .= '/**' . PHP_EOL;
		$code .= self::renderDocBlockLine($classEntity->doc_block->title);
		$code .= self::renderDocBlockLine();
		$code .= self::renderDocBlockLine('@package ' . $classEntity->namespace);
		$code .= self::renderDocBlockLine();
		$code .= ' */' . PHP_EOL;
		return $code;
	}
	
	private static function renderDocBlockLine($text = EMP) {
		$code = ' * ' . $text . PHP_EOL;
		return $code;
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
		return $code;
	}
	
}
