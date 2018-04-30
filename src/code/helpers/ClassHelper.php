<?php

namespace yii2lab\extension\code\helpers;

use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\Helper;
use yii2lab\extension\code\entities\ClassConstantEntity;
use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\ClassMethodEntity;
use yii2lab\extension\code\entities\ClassUseEntity;
use yii2lab\extension\code\entities\ClassVariableEntity;
use yii2lab\extension\code\entities\CodeEntity;
use yii2lab\extension\code\entities\DocBlockEntity;
use yii2lab\extension\code\entities\InterfaceEntity;
use yii2lab\helpers\yii\FileHelper;

/**
 * Class ClassHelper
 *
 * @package yii2lab\extension\code\helpers
 */
class ClassHelper
{
	
	public static function renderFromArray(array $data) {
		$classEntity = new ClassEntity();
		$classEntity->name = 'common\enums\rbac\PermissionEnum';
		$classEntity->is_abstract = true;
		$classEntity->extends = 'BaseEnum';
		$classEntity->implements = 'EnumInterface';
		$classEntity->doc_block = new DocBlockEntity([
			'title' => 'Class ' . $classEntity->name,
		]);
		$classEntity->uses = [
			new ClassUseEntity([
				'name' => 'ArTrait',
			]),
		];
		$classEntity->constants = [
			new ClassConstantEntity([
				'name' => 'typeOfVar',
				'value' => 'var',
			]),
		];
		$classEntity->variables = [
			new ClassVariableEntity([
				'name' => 'id',
				'value' => 'null',
			]),
			new ClassVariableEntity([
				'name' => 'name',
				'value' => 'null',
			]),
		];
		$classEntity->methods = [
			new ClassMethodEntity([
				'name' => 'one',
			]),
			new ClassMethodEntity([
				'name' => 'all',
			]),
		];
	}
	
	public static function generate(BaseEntity $classEntity, $uses = []) {
		$classCode = self::render($classEntity);
		$codeEntity = new CodeEntity();
		$codeEntity->namespace = $classEntity->namespace;
		$codeEntity->uses = Helper::forgeEntity($uses, ClassUseEntity::class);
		$codeEntity->code = $classCode;
		$code =  self::renderPhp($codeEntity);
		/** @var ClassEntity $classEntity */
		$pathName = FileHelper::getPath('@' . $classEntity->namespace);
		$fileName = $pathName . DS . $classEntity->name . DOT . 'php';
		FileHelper::save($fileName, $code);
	}
	
	public static function render(BaseEntity $classEntity) {
		$code = '';
		/** @var ClassEntity|InterfaceEntity $classEntity */
		$isClass = ! ($classEntity instanceof InterfaceEntity);
		$code .= static::renderDocBlock($classEntity);
		if($isClass) {
			$code .= static::renderHeader($classEntity);
		} else {
			$code .= static::renderHeaderInterface($classEntity);
		}
		$code .= ' {' . PHP_EOL;
		if($isClass) {
			$code .= static::renderUses($classEntity);
			$code .= static::renderConstants($classEntity);
			$code .= static::renderVariables($classEntity);
		}
		$code .= static::renderMethods($classEntity);
		$code .=  PHP_EOL . '}';
		return $code;
	}
	
	public static function renderPhp(CodeEntity $codeEntity) {
		$code = '<?php' . PHP_EOL;
		if($codeEntity->namespace != null) {
			$code .= PHP_EOL;
			$code .= 'namespace ' . $codeEntity->namespace . ';' . PHP_EOL;
		}
		if($codeEntity->uses != null) {
			$code .= PHP_EOL;
			foreach($codeEntity->uses as $useEntity) {
				$code .= 'use ' . $useEntity->name . ';' . PHP_EOL;
			}
		}
		$code .= PHP_EOL;
		if($codeEntity->code != null) {
			$code .= $codeEntity->code . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderUses(BaseEntity $classEntity) {
		if($classEntity->uses == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->uses as $useEntity) {
			$code .= TAB . 'use ' . $useEntity->name . ';' . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderConstants(BaseEntity $classEntity) {
		if($classEntity->constants == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->constants as $constantEntity) {
			$code .= TAB . 'const ' . $constantEntity->name . ' = ' . $constantEntity->value . ';' . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderVariables(BaseEntity $classEntity) {
		if($classEntity->variables == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->variables as $variableEntity) {
			$code .= TAB . 'var ' . $variableEntity->name . ' = ' . $variableEntity->value . ';' . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderMethods(BaseEntity $classEntity) {
		if($classEntity->methods == null) {
			return EMP;
		}
		$code = PHP_EOL;
		foreach($classEntity->methods as $methodEntity) {
			$code .= TAB . 'function ' . $methodEntity->name . '() {' . PHP_EOL . PHP_EOL . TAB . '}' . PHP_EOL . PHP_EOL;
		}
		return $code;
	}
	
	private static function renderDocBlock(BaseEntity $classEntity) {
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
		$code = trim($code);
		return $code;
	}
	
	private static function renderHeaderInterface(InterfaceEntity $classEntity) {
		$code = '';
		$code .= ' interface ' . $classEntity->getName();
		if($classEntity->extends) {
			$code .= ' extends ' . $classEntity->extends;
		}
		$code = trim($code);
		return $code;
	}
	
}
