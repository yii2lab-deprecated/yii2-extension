<?php

namespace yii2lab\extension\yii\widgets;

use yii\helpers\ArrayHelper;
use yii2lab\extension\yii\widgets\detailViewFormats\BooleanFormat;
use yii2lab\extension\yii\widgets\detailViewFormats\ListFormat;

class DetailView extends \yii\widgets\DetailView {
	
	public $widgets = [
		'boolean' => BooleanFormat::class,
		'list' => ListFormat::class,
	];
	
	protected function renderAttribute($attribute, $index)
	{
		/*if($attribute['class']) {
			$attribute['value'] = ;
		}*/
		
		if(isset($attribute['format'])) {
			$widget = ArrayHelper::getValue($this->widgets, $attribute['format']);
			if($widget) {
				$attribute['value'] = $widget::run($attribute['value']);
			}
			$attribute['format'] = 'html';
			//unset($attribute['format']);
		}
		return parent::renderAttribute($attribute, $index);
	}

}
