<?php

namespace yii2lab\extension\git\domain\repositories\file;

use yii2lab\extension\arrayTools\repositories\base\BaseActiveArrayRepository;
use yii2lab\extension\git\domain\interfaces\repositories\GitInterface;
use yii2lab\extension\git\domain\entities\GitEntity;
use yii2lab\extension\package\domain\helpers\ConfigRepositoryHelper;
use yii2mod\helpers\ArrayHelper;

/**
 * Class GitRepository
 * 
 * @package yii2lab\extension\git\domain\repositories\file
 * 
 * @property-read \yii2lab\extension\git\domain\Domain $domain
 */
class GitRepository extends BaseActiveArrayRepository implements GitInterface {

	protected $schemaClass = true;
	
	protected function getCollection() {
		/** @var GitEntity[] $packageCollection */
		$packageCollection = \App::$domain->package->package->all();
		$collection = [];
		foreach($packageCollection as $packageEntity) {
			$entity = new GitEntity;
			$entity->id = $packageEntity->id;
			
			$arr = $this->loadIni($entity->id);
			
			$entity->branches = $arr['branch'];
			$entity->remotes = $arr['remote'];
			
			
			//prr($entity,1,1);
			//$config = $this->loadConfig($entity->id);
			//$entity->config = $config;
			$collection[] = $entity;
		}
		return $collection;
	}
	
	private function loadIni($id) {
		$dir = ConfigRepositoryHelper::idToDir($id);
		$iniFile = $dir . DS . '.git' . DS . 'config';
		$gitConfig = parse_ini_file($iniFile, true);
		$arr = [];
		foreach($gitConfig as $name => $value) {
			$rr = explode(SPC, $name);
			ArrayHelper::setValue($arr, implode(DOT, $rr), $value);
		}
		
		$arr['branch'] = self::assignName($arr['branch']);
		$arr['remote'] = self::assignName($arr['remote']);
		
		return $arr;
	}
	
	private function assignName($array) {
		$flatArray = [];
		foreach($array as $name => $value) {
			$item = $value;
			$item['name'] = $name;
			$flatArray[] = $item;
		}
		return $flatArray;
	}
	
}
