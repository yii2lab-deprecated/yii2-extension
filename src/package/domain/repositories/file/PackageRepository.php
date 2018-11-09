<?php

namespace yii2lab\extension\package\domain\repositories\file;

use yii\helpers\ArrayHelper;
use yii2lab\extension\arrayTools\repositories\base\BaseActiveArrayRepository;
use yii2lab\extension\package\domain\entities\PackageEntity;
use yii2lab\extension\package\domain\interfaces\repositories\PackageInterface;
use yii2lab\extension\package\helpers\PackageHelper;

/**
 * Class PackageRepository
 * 
 * @package yii2lab\extension\package\domain\repositories\file
 * 
 * @property-read \yii2lab\extension\package\domain\Domain $domain
 */
class PackageRepository extends BaseActiveArrayRepository implements PackageInterface {

	protected $schemaClass = true;
	
	protected function getCollection() {
		$groupCollection = \App::$domain->package->group->all();
		$groups = ArrayHelper::getColumn($groupCollection, 'name');
		$tree = PackageHelper::getPackageTree($groups);
		$collection = [];
		foreach($tree as $group => $packages) {
			foreach($packages as $package) {
				$packageEntity = new PackageEntity();
				$packageEntity->group_name = $group;
				$packageEntity->name = $package;
				$collection[] = $packageEntity;
			}
		}
		return $collection;
	}
	
}
