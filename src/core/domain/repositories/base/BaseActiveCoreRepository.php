<?php

namespace yii2lab\extension\core\domain\repositories\base;

use Yii;
use yii\web\NotFoundHttpException;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;
use yii2lab\domain\data\query\Rest;
use yii2lab\domain\interfaces\repositories\CrudInterface;

class BaseActiveCoreRepository extends BaseCoreRepository implements CrudInterface {
	
	protected function allArray(Query $query) {
		$params = $this->getQueryParams($query);
		$responseEntity = $this->get(null, $params);
		return $responseEntity->data;
	}
	
	public function all(Query $query = null) {
		return $this->allWithRelation($query, 'allArray');
	}
	
	public function count(Query $query = null) {
		$params = $this->getQueryParams($query);
		$responseEntity = $this->get(null, $params);
		return $responseEntity->headers['x-pagination-total-count'];
	}
	
	public function one(Query $query = null) {
		/** @var Query $query */
		$query = Query::forge($query);
		$query->limit(1);
		$collection = $this->all($query);
		if(empty($collection)) {
			throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
		}
		return $collection[0];
	}
	
	public function oneById($id, Query $query = null) {
		//$query = $this->prepareQuery($query);
		
		$queryFilter = $this->queryFilterInstance($query);
		$queryWithoutRelations = $queryFilter->getQueryWithoutRelations();
		
		$params = $this->getQueryParams($queryWithoutRelations);
		$responseEntity = $this->get($id, $params);
		$entity = $this->forgeEntity($responseEntity->data);
		
		$entity = $queryFilter->loadRelations($entity);
		return $entity;
	}
	
	public function insert(BaseEntity $entity) {
		$this->post(null, $entity->toArray());
	}
	
	public function update(BaseEntity $entity) {
		$id = $this->getIdFromEntity($entity);
		$this->put($id, $entity->toArray());
	}
	
	public function delete(BaseEntity $entity) {
		$id = $this->getIdFromEntity($entity);
		$this->del($id);
	}
	
	protected function getQueryParams(Query $query = null) {
		$query = Query::forge($query);
		$restQuery = new Rest;
		$restQuery->query = $query;
		return $restQuery->getParams();
	}
	
	private function getIdFromEntity(BaseEntity $entity) {
		$id = $entity->{$this->primaryKey};
		return $id;
	}
	
}
