<?php

namespace yii2lab\extension\scenario\collections;

use yii\base\BaseObject;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\arrayTools\helpers\Collection;
use yii2lab\domain\values\BaseValue;
use yii2lab\extension\common\helpers\ClassHelper;
use yii2lab\extension\common\helpers\Helper;
use yii2lab\extension\scenario\exceptions\StopException;

class ScenarioCollection extends Collection {
	
	public $event;

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
	
	public function runIs($data = null, BaseObject $event = null) {
		try {
			$this->runAll($data, $event);
			return true;
		} catch(StopException $e) {
			return false;
		}
	}
    
	/**
	 * @param            $data
	 * @param BaseObject|null $event
	 *
	 * @return BaseValue
	 */
    public function runAll($data = null, BaseObject $event = null) {
	    /** @var BaseScenario[] $filterCollection */
	    $filterCollection = $this->all();
        if(empty($filterCollection)) {
            return $data;
        }
        $event = !empty($event) ? $event : $this->event;
        foreach($filterCollection as $filterInstance) {
	        $data = $this->runOne($filterInstance, $data, $event);
        }
        return $data;
    }
	
    private function runOne(BaseScenario $filterInstance, $data = null, BaseObject $event = null) {
	    $filterInstance->setData($data);
	    $filterInstance->event = $event;
	    $filterInstance->run();
	    $data = $filterInstance->getData();
	    return $data;
    }
    
}
