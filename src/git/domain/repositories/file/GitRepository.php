<?php

namespace yii2lab\extension\git\domain\repositories\file;

use yii2lab\extension\arrayTools\repositories\base\BaseActiveArrayRepository;
use yii2lab\extension\git\domain\helpers\GitConfigHelper;
use yii2lab\extension\git\domain\interfaces\repositories\GitInterface;
use yii2lab\extension\git\domain\entities\GitEntity;

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
			$arr = GitConfigHelper::loadIni($entity->id);
			$entity->branches = $arr['branch'];
			$entity->remotes = $arr['remote'];
			$entity->refs = GitConfigHelper::getRefs($entity->id);
			$entity->tags = GitConfigHelper::getTagsByRefs($entity->refs);
			$collection[] = $entity;
		}
		return $collection;
	}
	
}
