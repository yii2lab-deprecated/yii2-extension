<?php

namespace yii2lab\extension\arrayTools\traits;

use Yii;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\helpers\repository\QueryFilter;
use yii2lab\extension\arrayTools\helpers\ArrayIterator;
use yii2lab\domain\data\Query;
use yii\web\NotFoundHttpException;
use yii2lab\domain\Domain;
use yii2lab\domain\helpers\repository\RelationHelper;
use yii2lab\domain\helpers\repository\RelationWithHelper;

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

	abstract public function forgeEntity($data, $class = null);
	abstract protected function getCollection();
	
	public function relations() {
		return [];
	}
	
	public function isExists($query) {
		/** @var Query $query */
		if(is_array($query)) {
			$q = Query::forge();
			$q->whereFromCondition($query);
			$query = $q;
		}
		$query = Query::forge($query);
		try {
			$this->one($query);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	/**
	 * @param $id
	 *
	 * @return bool
	 */
	public function isExistsById($id) {
		try {
			$this->oneById($id);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	/**
	 * @param            $id
	 * @param Query|null $query
	 *
	 * @return BaseEntity
	 * @throws NotFoundHttpException
	 */
	public function oneById($id, Query $query = null) {
		/** @var Query $query */
		$query = Query::forge($query);
		$query->where($this->primaryKey, $id);
		return $this->one($query);
	}
	
	public function one(Query $query = null) {
		$query = Query::forge($query);
		$collection = $this->all($query);
		if(empty($collection)) {
			throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
		}
		$entity = $collection[0];
		return $entity;
	}

	public function all(Query $query = null) {
		$query = $this->prepareQuery($query);
		
		$queryFilter = Yii::createObject([
			'class' => QueryFilter::class,
			'repository' => $this,
			'query' => $query,
		]);
		$queryWithoutRelations = $queryFilter->getQueryWithoutRelations();
		
		$iterator = $this->getIterator();
		$array = $iterator->all($queryWithoutRelations);
		$collection = $this->forgeEntity($array);
		
		$collection = $queryFilter->loadRelations($collection);
		return $collection;
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