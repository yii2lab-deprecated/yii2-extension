<?php

namespace tests\functional\package\services;

use yii2lab\domain\data\Query;
use yii2lab\domain\helpers\DomainHelper;
use yii2lab\extension\package\domain\entities\ConfigEntity;
use yii2lab\extension\package\domain\entities\GroupEntity;
use yii2lab\extension\package\domain\entities\PackageEntity;
use yii2lab\test\Test\Unit;

class PackageTest extends Unit {
	
	const PACKAGE = 'yii2lab/yii2-extension';
	
	protected function _before() {
		parent::_before();
		DomainHelper::forgeDomains([
			'git' => 'yii2lab\extension\git\domain\Domain',
			'package' => 'yii2lab\extension\package\domain\Domain',
		]);
	}
	
	public function testAll() {
		/** @var PackageEntity[] $collection */
		$collection = \App::$domain->package->package->all();
		$this->tester->assertIsEntity($collection[0], PackageEntity::class);
	}
	
	public function testAllWithRel() {
		$query = Query::forge();
		$query->with('group');
		$query->with('config');
		/** @var PackageEntity[] $collection */
		$collection = \App::$domain->package->package->all($query);
		$this->tester->assertIsEntity($collection[0], PackageEntity::class);
		$this->tester->assertIsEntity($collection[0]->group, GroupEntity::class);
		$this->tester->assertIsEntity($collection[0]->config, ConfigEntity::class);
	}
	
	public function testOneById() {
		$entity = \App::$domain->package->package->oneById('yii2lab/yii2-extension');
		$this->tester->assertIsEntity($entity, PackageEntity::class);
	}
	
	public function testOneByIdWithRel() {
		$query = Query::forge();
		$query->with('group');
		$query->with('config');
		/** @var PackageEntity $entity */
		$entity = \App::$domain->package->package->oneById('yii2lab/yii2-extension', $query);
		$this->tester->assertIsEntity($entity, PackageEntity::class);
		$this->tester->assertIsEntity($entity->group, GroupEntity::class);
		$this->tester->assertIsEntity($entity->config, ConfigEntity::class);
	}
	
}
