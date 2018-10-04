<?php

namespace yii2lab\extension\yii\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\extension\yii\widgets\detailViewFormats\BooleanFormat;
use yii2lab\extension\yii\widgets\detailViewFormats\LinkFormat;
use yii2lab\extension\yii\widgets\detailViewFormats\ListFormat;
use yii2lab\extension\common\helpers\ClassHelper;
use yii2module\lang\domain\helpers\LangHelper;

class DetailView extends \yii\widgets\DetailView {
	
	public $labelWidth;
	public $widgets = [
		'boolean' => BooleanFormat::class,
		'list' => ListFormat::class,
		'link' => LinkFormat::class,
	];
	
	public function init() {
		if($this->labelWidth) {
			$css = '
			    table.detail-view#' . self::getId() . ' th {
			        width: '.$this->labelWidth.';
			    }';
			Yii::$app->view->registerCss($css);
		}
		parent::init();
	}
	
	protected function renderAttribute($attribute, $index) {
		if(isset($attribute['format'])) {
			$widget = ArrayHelper::getValue($this->widgets, $attribute['format']);
			if($widget) {
				$widgetDefinition = ClassHelper::normalizeComponentConfig($widget);
				if(isset($attribute['options'])) {
					$widgetDefinition = ArrayHelper::merge($widgetDefinition, $attribute['options']);
				}
				$widgetInstance = \Yii::createObject($widgetDefinition);
				$attribute['value'] = $widgetInstance->run($attribute['value']);
				$attribute['format'] = 'html';
			}
		}
		if(isset($attribute['label'])) {
			$attribute['label'] = LangHelper::extract($attribute['label']);
		}
		return parent::renderAttribute($attribute, $index);
	}
	
}
