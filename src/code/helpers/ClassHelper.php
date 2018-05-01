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

/**
 * Class ClassHelper
 *
 * @package yii2lab\extension\code\helpers
 */
class ClassHelper extends BaseClassHelper
{
	
	public static function generate(BaseEntity $classEntity, $uses = []) {
		$codeEntity = new CodeEntity();
		$codeEntity->fileName = $classEntity->namespace . DS . $classEntity->name;
		$codeEntity->namespace = $classEntity->namespace;
		$codeEntity->uses = Helper::forgeEntity($uses, ClassUseEntity::class);
		$codeEntity->code = self::render($classEntity);
		CodeHelper::save($codeEntity);
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
	
}
