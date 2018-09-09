<?php

namespace yii2lab\extension\web\grid;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\extension\yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{
	
	public $headerOptions = ['class' => 'action-column', 'width' => '20'];
	
	public $buttonOptions = ['class' => ['btn btn-xs']];
	
	public $template = '{view} {update} {delete}';

	public $idAttribute = 'id';
 
	public function createUrl($action, $model, $key, $index)
	{
		$key = ArrayHelper::getValue($model, $this->idAttribute);
		if (is_callable($this->urlCreator)) {
			return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
		} else {
			$params = is_array($key) ? $key : [$this->idAttribute => (string) $key];
			$params[0] = $this->controller ? $this->controller . '/' . $action : $action;
			return Url::toRoute($params);
		}
	}

	/**
	 * Initializes the default button rendering callbacks.
	 */
	protected function initDefaultButtons()
	{
		if (!isset($this->buttons['view'])) {
			$this->buttons['view'] = function ($url, $model, $key) {
				$options = array_merge_recursive([
					'title' => Yii::t('yii', 'View'),
					'aria-label' => Yii::t('yii', 'View'),
					'data-pjax' => '0',
				], $this->buttonOptions);
				return Html::a(Html::fa('eye'), $url, $options);
			};
		}
		if (!isset($this->buttons['update'])) {
			$this->buttons['update'] = function ($url, $model, $key) {
				$options = array_merge_recursive([
					'title' => Yii::t('yii', 'Update'),
					'aria-label' => Yii::t('yii', 'Update'),
					'data-pjax' => '0',
					//'class' => ['btn-primary'],
				], $this->buttonOptions);
				return Html::a(Html::fa('pencil'), $url, $options);
			};
		}
		if (!isset($this->buttons['delete'])) {
			$this->buttons['delete'] = function ($url, $model, $key) {
				$options = array_merge_recursive([
					'title' => Yii::t('yii', 'Delete'),
					'aria-label' => Yii::t('yii', 'Delete'),
					'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
					'data-method' => 'post',
					'data-pjax' => '0',
					//'class' => ['btn-danger'],
				], $this->buttonOptions);
				return Html::a(Html::fa('trash', 'danger'), $url, $options);
			};
		}
		if (!isset($this->buttons['complete'])) {
			$this->buttons['complete'] = function ($url, $model, $key) {
				$options = array_merge_recursive([
					'title' => Yii::t('main', 'complete'),
					'aria-label' => Yii::t('main', 'complete'),
					'data-confirm' => Yii::t('main', 'complete_confirm'),
					'data-method' => 'post',
					'data-pjax' => '0',
					//'class' => ['btn-success'],
				], $this->buttonOptions);
				return Html::a(Html::fa('check', 'success'), $url, $options);
			};
		}
	}

}
