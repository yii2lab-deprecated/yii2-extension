<?php

namespace yii2lab\extension\yii\widgets\detailViewFormats;

use yii2lab\extension\yii\helpers\Html;

class ListFormat {
	
	const VIEW_LIST = 'VIEW_LIST';
	const VIEW_INLINE = 'VIEW_INLINE';
	
	public $view = self::VIEW_LIST;
	
	public function run($value) {
		if($this->view == self::VIEW_LIST) {
			return Html::ulRaw($value);
		} else {
			return implode(', ', $value);
		}
	}
	
}
