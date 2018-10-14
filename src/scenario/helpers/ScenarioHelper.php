<?php

namespace yii2lab\extension\scenario\helpers;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\arrayTools\helpers\Collection;
use yii2lab\domain\values\BaseValue;
use yii2lab\extension\common\helpers\ClassHelper;
use yii2lab\extension\common\helpers\Helper;
use yii2lab\extension\scenario\interfaces\RunInterface;

/**
 * Class ScenarioHelper
 * @package yii2lab\extension\scenario\helpers
 *
 */
class ScenarioHelper {
	
	public static function runHandler($handlerDefinition, $data) {
		/** @var RunInterface $handlerInstance */
		$handlerInstance = ClassHelper::createInstance($handlerDefinition, $data, RunInterface::class);
		return $handlerInstance->run();
	}
	
	/**
	 * @param $definitionArray
	 *
	 * @return Collection
	 * @deprecated use $filterCollection = new ScenarioCollection($filters); $data = $filterCollection->runAll($data);
	 */
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
	 * @deprecated use $filterCollection = new ScenarioCollection($filters); $data = $filterCollection->runAll($data);
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
	 * @deprecated use $filterCollection = new ScenarioCollection($filters); $data = $filterCollection->runAll($data);
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
