<?php

namespace yii2lab\extension\yii\widgets\detailViewFormats;

use yii2lab\extension\yii\helpers\Html;

class BooleanFormat {
	
	public function run($value) {
		return Html::renderBoolean($value);
	}

}
