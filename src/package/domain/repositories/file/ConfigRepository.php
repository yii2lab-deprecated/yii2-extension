<?php

namespace yii2lab\extension\package\domain\repositories\file;

use yii2lab\domain\BaseEntity;
use yii2lab\extension\arrayTools\repositories\base\BaseActiveArrayRepository;
use yii2lab\extension\package\domain\entities\ConfigEntity;
use yii2lab\extension\package\domain\entities\PackageEntity;
use yii2lab\extension\package\domain\helpers\ConfigRepositoryHelper;
use yii2lab\extension\package\domain\interfaces\repositories\ConfigInterface;
use yii2lab\extension\store\StoreFile;
use yii2lab\extension\yii\helpers\FileHelper;

/**
 * Class ConfigRepository
 *
 * @package yii2lab\extension\package\domain\repositories\file
 *
 * @property-read \yii2lab\extension\package\domain\Domain $domain
 */
class ConfigRepository extends BaseActiveArrayRepository implements ConfigInterface {
	
	protected $schemaClass = true;
	
	protected function getCollection() {
		/** @var PackageEntity[] $packageCollection */
		$packageCollection = \App::$domain->package->package->all();
		$collection = [];
		foreach($packageCollection as $packageEntity) {
			$entity = new ConfigEntity;
			$entity->id = $packageEntity->id;
			$config = $this->loadConfig($entity->id);
			$entity->config = $config;
			$collection[] = $entity;
		}
		return $collection;
	}
	
	public function update(BaseEntity $entity) {
		/** @var ConfigEntity $entity */
		$entity->hideAttributes(['config']);
		$entity = new ConfigEntity($entity->toArray());
		$this->saveConfig($entity->id, $entity->config);
	}
	
	private function idToFileName($id) {
		$dir = ConfigRepositoryHelper::idToDir($id);
		$configFile = $dir . DS . 'composer.json';
		return $configFile;
	}
	
	private function saveConfig($id, $data) {
		$configFile = $this->idToFileName($id);
		$store = new StoreFile($configFile);
		return $store->save($data);
	}
	
	private function loadConfig($id) {
		$configFile = $this->idToFileName($id);
		$store = new StoreFile($configFile);
		$config = $store->load();
		$config = is_array($config) ? $config : [];
		return $config;
	}
	
}
