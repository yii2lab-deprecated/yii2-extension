<?php

namespace yii2lab\extension\code\scenarios\generator;

use yii2lab\domain\interfaces\services\CrudInterface;
use yii2lab\extension\code\entities\DocBlockEntity;
use yii2lab\extension\code\entities\InterfaceEntity;
use yii2lab\extension\code\helpers\ClassHelper;

class ServiceInterfaceGenerator extends BaseGenerator {

	public $name;
	
	public function run() {
		$classEntity = new InterfaceEntity();
		$classEntity->name = $this->name;
		$classEntity->extends = 'CrudInterface';
		$classEntity->doc_block = new DocBlockEntity([
			'title' => 'Class ' . $classEntity->name,
		]);
		ClassHelper::generate($classEntity, [
			['name' => CrudInterface::class],
		]);
	}
	
}
