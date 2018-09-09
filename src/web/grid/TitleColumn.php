<?php

namespace yii2lab\extension\web\grid;

use Yii;
use yii\grid\Column;
use yii\helpers\ArrayHelper;
use yii2lab\extension\yii\helpers\Html;

class TitleColumn extends Column
{
	
	/**
	 * @inheritdoc
	 */
	public $headerOptions = ['class' => 'action-column'];

	public $urlCreator;

	public $attribute = 'title';

	public $key = 'id';

	public $baseUrl;

	public function createUrl($action, $model, $key, $index) {
		$url = $this->baseUrl . $action . '?' . $key . '=' . $index;
		return $url;
	}

	/**
	 * @inheritdoc
	 */
	protected function renderDataCellContent($model, $key, $index)
	{
		$title = ArrayHelper::getValue($model, $this->attribute);
		$index = ArrayHelper::getValue($model, $this->key);
		$url = $this->createUrl('view', $model, $this->key, $index);
		return Html::a($title, $url);
	}

}
