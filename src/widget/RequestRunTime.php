<?php

namespace yii2lab\extension\widget;

use yii\base\Widget;
use yii2lab\extension\enum\enums\TimeEnum;
use yii2lab\extension\yii\helpers\Html;

class RequestRunTime extends Widget {
	
	public $precision = 2;
	
	public function run() {
		$runtime = microtime(true) - MICRO_TIME;
		$label = round($runtime, $this->precision) . ' s';
		echo Html::tag('span', $label, [
			'title' => 'runtime: ' . $runtime . ' (' . round($runtime / TimeEnum::SECOND_PER_MILLISECOND) . ' ms)',
		]);
	}
	
}