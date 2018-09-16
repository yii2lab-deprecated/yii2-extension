<?php

namespace yii2lab\extension\scenario\base;

use yii\base\BaseObject;
use yii2lab\extension\scenario\collections\ScenarioCollection;
use yii2lab\extension\scenario\helpers\ScenarioHelper;

abstract class BaseGroupScenario extends BaseScenario {

    public $filters = [];

    public function run() {
        if(empty($this->filters)) {
            return;
        }
        $config = $this->getData();

        $filterCollection = new ScenarioCollection($this->filters);
        $config = $filterCollection->runAll($config);

        //$filterCollection = ScenarioHelper::forgeCollection($this->filters);
        //$config = ScenarioHelper::runAll($filterCollection, $config);

        $this->setData($config);
    }
	
}
