<?php

namespace yii2lab\extension\activeRecord\traits;

use yii2lab\domain\Alias;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;
use yii2lab\domain\helpers\ErrorCollection;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;
use yii2lab\domain\helpers\repository\QueryFilter;
use yii2lab\domain\traits\repository\ReadOneTrait;

trait ActiveRepositoryTrait {
	
	use ReadOneTrait;
	
	/**
	 * @return Alias
	 */
	abstract public function getAlias();
	
	/**
	 * @param Query|null $query
	 *
	 * @return Query
	 */
	abstract protected function prepareQuery(Query $query = null);
	
	/**
	 * @param Query|null $query
	 *
	 * @return QueryFilter
	 */
	abstract protected function queryFilterInstance(Query $query = null);
		
		
		/*public function one(Query $query = null) {
			$query = $this->prepareQuery($query);
			if(!$query->hasParam('where') || $query->getParam('where') == []) {
				throw new InvalidArgumentException(\Yii::t('domain:domain/repository', 'where_connot_be_empty'));
			};
			$query2 = clone $query;
			$with = RelationWithHelper::cleanWith($this->relations(), $query);
			$model = $this->oneModel($query);
			if(empty($model)) {
				throw new NotFoundHttpException(__METHOD__ . ': ' . __LINE__);
			}
			$entity = $this->forgeEntity($model);
			if(!empty($with)) {
				$entity = RelationHelper::load($this->domain->id, $this->id, $query2, $entity);
			}
			return $entity;
		}*/
	
	public function all(Query $query = null) {
		return $this->allWithRelation($query, 'allModels');
	}
	
	protected function oneModelByCondition($condition, Query $query = null) {
		/** @var Query $query */
		$query = $this->prepareQuery($query);
		$query->whereFromCondition($condition);
		$model = $this->oneModel($query);
		if(empty($model)) {
			throw new NotFoundHttpException(__METHOD__ . ': ' . __LINE__);
		}
		return $model;
	}
	
	protected function allModelsByCondition($condition = [], Query $query = null) {
		/** @var Query $query */
		$query = $this->prepareQuery($query);
		$query->whereFromCondition($condition);
		$models = $this->allModels($query);
		return $models;
	}
	
	protected function findUniqueItem(BaseEntity $entity, $uniqueItem, $isUpdate = false) {
		$condition = [];
		if(!empty($uniqueItem) && is_array($uniqueItem)) {
			foreach($uniqueItem as $name) {
				//$entityValue = $entity->{$name};
				if(!empty(isset($entity->{$name}))) {
					$condition[ $name ] = $entity->{$name};
				}
			}
		}
		if(empty($condition)) {
			return;
		}
		try {
			$first = $this->oneModelByCondition($condition);
			if(!empty($this->primaryKey)) {
				$encodedPkName = $this->getAlias()->encode($this->primaryKey);
				if($isUpdate && $entity->{$this->primaryKey} == $first[$encodedPkName]) {
				
				} else {
					$error = new ErrorCollection();
					foreach($uniqueItem as $name) {
						$error->add($name, 'domain/db', 'already_exists {value}', ['value' => $entity->{$name}]);
					}
					throw new UnprocessableEntityHttpException($error);
				}
			}
		} catch(NotFoundHttpException $e) {
			
		}
	}
	
}