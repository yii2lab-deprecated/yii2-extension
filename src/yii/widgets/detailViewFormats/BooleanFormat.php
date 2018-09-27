<?php

namespace yii2lab\extension\yii\widgets\detailViewFormats;

class BooleanFormat {
	
	public function run($value) {
		$value = boolval($value);
		return $value ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
	}

}
