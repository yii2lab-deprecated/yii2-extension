<?php

namespace yii2lab\extension\pagination\data;

use yii\data\ArrayDataProvider;

class VirtualArrayDataProvider extends ArrayDataProvider {
	/**
	 * Value indicating the total number of data models in this data provider.
	 * @var int
	 */
	public $count;
	
	/*
	 * @var int
	 */
	//public $lastChanged;
	
	public function getTotalCount() {
		return $this->count;
	}
}

