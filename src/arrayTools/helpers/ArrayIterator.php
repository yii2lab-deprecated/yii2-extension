<?php

namespace yii2lab\extension\arrayTools\helpers;

use yii\web\NotFoundHttpException;
use yii2lab\extension\scenario\helpers\ScenarioHelper;
use yii2lab\domain\data\Query;
use yii2lab\extension\common\helpers\ReflectionHelper;

class ArrayIterator  {
	
	// сохраняем порядок фильтров как есть
	const FILTER_WHERE = 'where';
	const FILTER_SORT = 'sort';
	const FILTER_OFFSET = 'offset';
	
	protected $collection;
	
	public static function oneFromArray(Query $query = null, $array) {
		$array = !empty($array) ? $array : [];
		$iterator = new static();
		$iterator->setCollection($array);
		return $iterator->one($query);
	}
	
	public static function allFromArray(Query $query = null, $array) {
		$iterator = new static();
		$iterator->setCollection($array);
		return $iterator->all($query);
	}
	
	public function setCollection(Array $value) {
		$this->collection = $value;
	}
	
	public function one(Query $query = null, $filters = [self::FILTER_SORT, self::FILTER_WHERE]) {
		$collection = $this->runFilters($query, $filters);
		if(empty($collection) || empty($collection[0])) {
			throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
		}
		return $collection[0];
	}
	
	public function all(Query $query = null, $filters = [self::FILTER_SORT, self::FILTER_WHERE, self::FILTER_OFFSET]) {
		$collection = $this->runFilters($query, $filters);
		return $collection;
	}
	
	public function count(Query $query = null) {
		$collection = $this->runFilters($query, [self::FILTER_WHERE]);
		return count($collection);
	}
	
	protected function runFilters(Query $query = null, $filters = [self::FILTER_SORT, self::FILTER_WHERE, self::FILTER_OFFSET]) {
		$query = Query::forge($query);
		$collection = $this->collection;
		$allFilters = ReflectionHelper::getConstantsValuesByPrefix($this,'filter');
		foreach($allFilters as $filterName) {
			if(in_array($filterName, $filters)) {
				$filterConfig = [
					'class' => 'yii2lab\extension\arrayTools\filters\iterator\\' . ucfirst($filterName),
					'query' => $query,
				];
				$collection = ScenarioHelper::run($filterConfig, $collection);
			}
		}
		$collection = array_values($collection);
		return $collection;
	}
	
}