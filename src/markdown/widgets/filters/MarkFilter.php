<?php

namespace yii2lab\extension\markdown\widgets\filters;

use yii\web\ErrorHandler;
use yii2lab\extension\scenario\base\BaseScenario;

class MarkFilter extends BaseScenario {
	
	public function run() {
		$html = $this->getData();
		$html = $this->replace($html);
		$this->setData($html);
	}
	
	private function replace($html) {
		$pattern = '~\[\[(.+?)\]\]~';
		$html = preg_replace_callback($pattern, function($matches) {
			$arr2 = explode('|', $matches[1]);
			$className = $arr2[0];
			$handler = new ErrorHandler();
			return $handler->addTypeLinks($className);
		}, $html);
		return $html;
	}

}
