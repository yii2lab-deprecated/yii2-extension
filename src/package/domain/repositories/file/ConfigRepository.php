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
	
	public function oneByDir($dir) {
		$entity = new ConfigEntity;
		$entity->dir = $dir;
		$config = $this->loadConfig($entity->dir);
		$entity->config = $config;
		return $entity;
	}
	
	protected function getCollection() {
		/** @var PackageEntity[] $packageCollection */
		$packageCollection = \App::$domain->package->package->all();
		$collection = [];
		foreach($packageCollection as $packageEntity) {
			
			$collection[] = $this->oneByDir($packageEntity->dir);
		}
		return $collection;
	}
	
	public function update(BaseEntity $entity) {
		/** @var ConfigEntity $entity */
		$entity->hideAttributes(['config']);
		$entity = new ConfigEntity($entity->toArray());
		$this->saveConfig($entity->dir, $entity->config);
	}
	
	private function idToFileName($dir) {
		$configFile = $dir . DS . 'composer.json';
		return $configFile;
	}
	
	private function saveConfig($dir, $data) {
		$configFile = $this->idToFileName($dir);
		$store = new StoreFile($configFile);
		return $store->save($data);
	}
	
	private function loadConfig($dir) {
		$configFile = $this->idToFileName($dir);
		$store = new StoreFile($configFile);
		$config = $store->load();
		$config = is_array($config) ? $config : [];
		return $config;
	}
	
}
