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
use yii2lab\extension\yii\helpers\ArrayHelper;

/**
 * Class ClassHelper
 *
 * @package yii2lab\extension\code\helpers
 */
class ClassHelper
{
	
	public static function classNameToFileName($class) {
		$alias = str_replace(['\\', '/'], SL, $class);
		return \Yii::getAlias('@' . $alias);
	}
	
	public static function generate(BaseEntity $entity, $uses = []) {
		$codeEntity = new CodeEntity();
		/** @var ClassEntity|InterfaceEntity $entity */
		$codeEntity->fileName = $entity->namespace . DS . $entity->name;
		$codeEntity->namespace = $entity->namespace;
		$codeEntity->uses = Helper::forgeEntity($uses, ClassUseEntity::class);
		$codeEntity->code = self::render($entity);
		CodeHelper::save($codeEntity);
	}
	
	private static function render(BaseEntity $entity) {
		/** @var ClassRender|InterfaceRender $render */
		if($entity instanceof ClassEntity) {
			$render = new ClassRender();
		} elseif($entity instanceof InterfaceEntity) {
			$render = new InterfaceRender();
		}
		$render->entity = $entity;
		return $render->run();
	}
	
}
