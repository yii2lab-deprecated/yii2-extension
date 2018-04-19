<?php

namespace yii2lab\extension\queue\drivers\file;

class Queue extends \yii\queue\file\Queue {
	
	public $autoRun = false;
	
	public function init() {
		parent::init();
		if($this->autoRun) {
			$this->run(false);
		}
	}
	
}
