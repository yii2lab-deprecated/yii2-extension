<?php

namespace yii2lab\extension\scenario\collections;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\domain\data\Collection;
use yii2lab\domain\values\BaseValue;
use yii2lab\extension\scenario\helpers\ScenarioHelper;
use yii2lab\helpers\ClassHelper;
use yii2lab\helpers\Helper;

class ScenarioCollection extends Collection {

    protected function loadItems($items) {
        $items = $this->filterItems($items);
        return parent::loadItems($items);
    }

    private function filterItems($items) {
        $result = [];
        foreach($items as $definition) {
            $definition = Helper::isEnabledComponent($definition);
            if($definition) {
                $filterInstance = ClassHelper::createObject($definition, [], BaseScenario::class);
                if($filterInstance->isEnabled()) {
                    $result[] = $filterInstance;
                }
            }
        }
        return $result;
    }

    /**
     * @param            $data
     *
     * @return BaseValue
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function runAll($data = null) {
        $filterCollection = $this->all();
        if(empty($filterCollection)) {
            return $data;
        }
        foreach($filterCollection as $filterInstance) {
            $filterInstance->setData($data);
            $filterInstance->run();
            $data = $filterInstance->getData();
        }
        return $data;
    }
	
}
