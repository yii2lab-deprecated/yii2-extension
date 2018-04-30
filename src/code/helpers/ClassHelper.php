<?php

namespace yii2lab\extension\code\helpers;

use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\Helper;
use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\ClassUseEntity;
use yii2lab\extension\code\entities\CodeEntity;
use yii2lab\extension\code\entities\InterfaceEntity;
use yii2lab\extension\code\render\ClassRender;
use yii2lab\extension\code\render\InterfaceRender;
use yii2lab\helpers\yii\FileHelper;
use yii2lab\store\Store;

/**
 * Class ClassHelper
 *
 * @package yii2lab\extension\code\helpers
 */
class ClassHelper extends BaseClassHelper
{
	
	public static function generatePhpData($alias, $data) {
		$codeEntity = new CodeEntity();
		$store = new Store('php');
		$content = $store->encode($data);
		$codeEntity->code = 'return ' . $content . ';';
		$pathName = FileHelper::getPath('@' . $alias);
		FileHelper::save($pathName . DOT . 'php', self::renderPhp($codeEntity));
	}
	
	public static function generatePhp($alias, $code) {
		$codeEntity = new CodeEntity();
		$codeEntity->code = $code;
		$pathName = FileHelper::getPath('@' . $alias);
		FileHelper::save($pathName . DOT . 'php', self::renderPhp($codeEntity));
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
	
	private static function render(BaseEntity $classEntity) {
		/** @var ClassRender|InterfaceEntity $render */
		if($classEntity instanceof ClassEntity) {
			$render = new ClassRender();
		} elseif($classEntity instanceof InterfaceEntity) {
			$render = new InterfaceRender();
		}
		$render->classEntity = $classEntity;
		return $render->run();
	}
	
	private static function renderPhp(CodeEntity $codeEntity) {
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
	
}
