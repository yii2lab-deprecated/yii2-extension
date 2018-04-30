<?php

namespace yii2lab\extension\code\scenarios\generator;

use yii2lab\domain\services\base\BaseActiveService;
use yii2lab\extension\code\entities\ClassEntity;
use yii2lab\extension\code\entities\DocBlockEntity;
use yii2lab\extension\code\helpers\ClassHelper;

class ServiceGenerator extends BaseGenerator {

	public $name;
	
	public function run() {
		$classEntity = new ClassEntity();
		$classEntity->name = $this->name;
		$classEntity->extends = 'BaseActiveService';
		$classEntity->doc_block = new DocBlockEntity([
			'title' => 'Class ' . $classEntity->name,
		]);
		ClassHelper::generate($classEntity, [
			['name' => BaseActiveService::class],
		]);
	}
	
}
