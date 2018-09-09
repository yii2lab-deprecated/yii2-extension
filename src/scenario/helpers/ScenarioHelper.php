<?php

namespace yii2lab\extension\scenario\helpers;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\domain\data\Collection;
use yii2lab\domain\values\BaseValue;
use yii2lab\helpers\ClassHelper;
use yii2lab\helpers\Helper;

class ScenarioHelper {
	
	public static function forgeCollection($definitionArray) {
		$collection = new Collection($definitionArray);
		return $collection;
	}
	
	/**
	 * @param $definition
	 * @param $data
	 *
	 * @return mixed
	 * @throws InvalidConfigException
	 * @throws ServerErrorHttpException
	 */
	public static function run($definition, $data = null) {
		$definition = Helper::isEnabledComponent($definition);
		if(!$definition) {
			return $data;
		}
		/** @var BaseScenario $filterInstance */
		$filterInstance = ClassHelper::createObject($definition, [], BaseScenario::class);
		if(!$filterInstance->isEnabled()) {
			return $data;
		}
		$filterInstance->setData($data);
		$filterInstance->run();
		return $filterInstance->getData();
	}
	
	/**
	 * @param Collection $filterCollection
	 * @param            $data
	 *
	 * @return BaseValue
	 * @throws InvalidConfigException
	 * @throws ServerErrorHttpException
	 */
	public static function runAll(Collection $filterCollection, $data = null) {
		
		if(empty($filterCollection)) {
			return $data;
		}
		$filterCollection = ArrayHelper::toArray($filterCollection);
		foreach($filterCollection as $definition) {
			$definition = Helper::isEnabledComponent($definition);
			if($definition) {
				$data = self::run($definition, $data);
			}
		}
		return $data;
	}
	
}
