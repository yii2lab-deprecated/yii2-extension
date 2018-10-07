<?php

namespace yii2lab\extension\arrayTools\traits;

use yii2lab\domain\traits\repository\ReadOneTrait;
use yii2lab\extension\arrayTools\helpers\ArrayIterator;
use yii2lab\domain\data\Query;
use yii2lab\domain\Domain;

/**
 * Trait ArrayReadTrait
 *
 * @package yii2lab\extension\arrayTools\traits
 *
 * @property string $id
 * @property string $primaryKey
 * @property Domain $domain
 */
trait ArrayReadTrait {

	use ReadOneTrait;
	
	abstract public function forgeEntity($data, $class = null);
	abstract protected function getCollection();
	
	/**
	 * @param Query|null $query
	 *
	 * @return array|mixed
	 * @deprecated
	 */
	public function allArray(Query $query = null) {
		$iterator = $this->getIterator();
		$array = $iterator->all($query);
		$array = $this->forgeEntity($array);
		return $array;
	}
	
	public function all(Query $query = null) {
		return $this->allWithRelation($query, 'allArray');
	}
	
	public function count(Query $query = null) {
		$query = Query::forge($query);
		$iterator = $this->getIterator();
		return $iterator->count($query);
	}

	private function getIterator() {
		$collection = $this->getCollection();
		$iterator = new ArrayIterator();
		$iterator->setCollection($collection);
		return $iterator;
	}
	
}