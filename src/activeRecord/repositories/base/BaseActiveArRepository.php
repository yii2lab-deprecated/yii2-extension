<?php

namespace yii2lab\extension\activeRecord\repositories\base;

use yii\db\Exception;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;
use yii2lab\domain\exceptions\BadQueryHttpException;
use yii2lab\domain\interfaces\repositories\CrudInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii2lab\domain\interfaces\repositories\SearchInterface;
use yii2lab\extension\activeRecord\helpers\SearchHelper;
use yii2lab\extension\activeRecord\traits\ActiveRepositoryTrait;

abstract class BaseActiveArRepository extends BaseArRepository implements CrudInterface, SearchInterface {
	
	use ActiveRepositoryTrait;
	
	public function searchByText($text, Query $query = null) {
		$query = $this->prepareQuery($query);
		$searchByTextFields = $this->searchByTextFields();
		SearchHelper::appendSearchCondition($query, $searchByTextFields, $text);
		return $this->getDataProvider($query);
	}
	
	public function count(Query $query = null) {
		$this->queryValidator->validateWhereFields($query);
		$this->resetQuery();
		$this->forgeQueryForAll($query);
		$this->forgeQueryForWhere($query);
		try {
			return (int) $this->query->count();
		} catch(Exception $e) {
			throw new BadQueryHttpException(null, 0, $e);
		}
	}
	
	protected function forgeUniqueFields() {
		$unique = $this->uniqueFields();
		if(!empty($unique)) {
			$unique = ArrayHelper::toArray($unique);
		}
		if(!empty($this->primaryKey)) {
			$unique[] = [$this->primaryKey];
		}
		return $unique;
	}
	
	protected function findUnique(BaseEntity $entity, $isUpdate = false) {
		$unique = $this->forgeUniqueFields();
		foreach($unique as $uniqueItem) {
			$this->findUniqueItem($entity, $uniqueItem, $isUpdate);
		}
	}
	
	public function insert(BaseEntity $entity) {
		$entity->validate();
		$this->findUnique($entity);
		/** @var ActiveRecord $model */
		$model = Yii::createObject(get_class($this->model));
		$this->massAssignment($model, $entity, self::SCENARIO_INSERT);
		$result = $this->saveModel($model);
		if(!empty($this->primaryKey) && $result) {
			try {
				//TODO: а как же блокировка транзакции? Выяснить!
				$sequenceName = empty($this->tableSchema['sequenceName']) ? '' : $this->tableSchema['sequenceName'];
				$id = Yii::$app->db->getLastInsertID($sequenceName);
				$entity->{$this->primaryKey} = $id;
				
				// todo: как вариант
				/*$tableSchema = Yii::$app->db->getTableSchema($this->tableSchema['name']);
				$entity->{$this->primaryKey} =  Yii::$app->db->getLastInsertID($tableSchema->sequenceName);*/
				
			}catch(\Exception $e) {
				return null;
				//throw new ServerErrorHttpException('Postgre sequence error');
			}
		}
		return $entity;
	}
	
	public function update(BaseEntity $entity) {
		$entity->validate();
		$this->findUnique($entity, true);
		
		if(!empty($this->primaryKey)) {
			$entityPk = $entity->{$this->primaryKey};
			$condition = [$this->primaryKey => $entityPk];
		} else {
			$condition = $entity->toArray();
			$uniqueFields = ArrayHelper::getValue($this->uniqueFields(), '0', []);
			$condition = \yii2lab\extension\yii\helpers\ArrayHelper::extractByKeys($condition, $uniqueFields);
		}
		$model = $this->findOne($condition);
		$this->massAssignment($model, $entity, self::SCENARIO_UPDATE);
		$this->saveModel($model);
	}
	
	public function delete(BaseEntity $entity) {
		if(!empty($this->primaryKey)) {
			$entityPk = $entity->{$this->primaryKey};
			$condition = [$this->primaryKey => $entityPk];
		} else {
			$condition = $entity->toArray();
		}
		$this->deleteOne($condition);
	}
	
	/**
	 * @param $condition
	 *
	 * @return ActiveRecord
	 * @throws NotFoundHttpException
	 */
	protected function findOne($condition) {
		$condition = $this->alias->encode($condition);
		$model = $this->model->findOne($condition);
		if(empty($model)) {
			throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
		}
		return $model;
	}
	
	protected function deleteOne($condition) {
		$this->findOne($condition);
		$encodedCondition = $this->alias->encode($condition);
		$this->model::deleteAll($encodedCondition);
	}
	
	public function deleteAll($condition) {
		$encodedCondition = $this->alias->encode($condition);
		$this->model->deleteAll($encodedCondition);
	}
	
	public function truncate() {
		Yii::$app->db->createCommand()->truncateTable($this->model->tableName())->execute();
	}
}
