<?php

namespace yii2lab\extension\markdown\widgets\filters;

use Yii;
use yii2lab\extension\scenario\base\BaseScenario;

class AlertFilter extends BaseScenario {

	public function run() {
		$html = $this->getData();
		$html = $this->replace($html);
		$this->setData($html);
	}

	private function replace($html) {
		$pattern = '~<blockquote>\s*<p>\s*(\w+?)\:~';
		$html = preg_replace_callback($pattern, function($matches) {
			
			return '<blockquote class="'.strtolower($matches[1]).'"><p><b>'.Yii::t('guide/blocktypes', strtolower($matches[1])).'</b>:';
		}, $html);
		return $html;
	}

}
