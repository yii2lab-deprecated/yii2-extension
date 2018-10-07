<?php

namespace yii2lab\extension\pagination\helpers;

use Yii;
use yii\data\BaseDataProvider;
use yii2lab\domain\data\Query;
use yii2lab\extension\pagination\data\VirtualArrayDataProvider;
use yii2lab\extension\yii\helpers\ArrayHelper;

class DataProviderFactory {
	
	public static function create($config, Query $query = null) {
		$config = self::prepareClass($config);
		$config = self::prepareKey($config);
		$config = self::preparePagination($config, $query);
		/** @var BaseDataProvider $dataProvider */
		$dataProvider = Yii::createObject($config);
		return $dataProvider;
	}
	
	private static function prepareClass($config) {
		if(!isset($config['class'])) {
			$config['class'] = VirtualArrayDataProvider::class;
		}
		return $config;
	}
	
	private static function prepareKey($config) {
		if(!isset($config['key'])) {
			$config['key'] = self::getPrimaryKey($config);
			if (empty($config['key'])) {
				$config['key'] = 'id';
			}
		}
		return $config;
	}
	
	private static function preparePagination($config, Query $query) {
		if(!isset($config['pagination']['pageSize'])) {
			$limit = $query->getParam(Query::LIMIT);
			if($limit) {
				$config['pagination']['pageSize'] = $limit;
			}
		}
		return $config;
	}
	
	private static function getPrimaryKey($config) {
		$keys = self::getKeys($config);
		if(empty($keys)) {
			return null;
		}
		return $keys[0];
	}
	
	private static function getKeys($config) {
		if(empty($config['allModels'])) {
			return null;
		}
		$models = ArrayHelper::toArray($config['allModels']);
		if(empty($models[0])) {
			return null;
		}
		return array_keys($models[0]);
	}
	
}
