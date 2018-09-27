<?php

namespace yii2lab\extension\yii\widgets\detailViewFormats;

class ListFormat {
	
	public static function run($value) {
		return implode(', ', $value);
	}

}
