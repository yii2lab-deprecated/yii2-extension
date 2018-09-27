<?php

namespace yii2lab\extension\widget\entityActions;

use Yii;
use yii\base\Widget;
use yii2lab\extension\web\enums\HtmlEnum;
use yii2lab\extension\widget\entityActions\actions\BaseAction;
use yii2lab\extension\widget\entityActions\actions\DeleteAction;
use yii2lab\extension\widget\entityActions\actions\UpdateAction;
use yii2lab\extension\yii\helpers\ArrayHelper;

class EntityActionsWidget extends Widget {
	
	public $splitter = HtmlEnum::NBSP . HtmlEnum::NBSP;
	public $actions = ['update', 'delete'];
	public $actionsDefinition = [
		'update' => UpdateAction::class,
		'delete' => DeleteAction::class,
	];
	
	public $baseUrl;
	public $id;
	public $iconTemplate = '<i class="fa fa-{name} text-{type}"></i>';
	public $urlTemplate = '/{base}/{action}?id={id}';
	public $linkOptions = [];
	
	public function run() {
		foreach($this->actions as $action) {
			$button = ArrayHelper::getValue($this->actionsDefinition, $action);
			$buttonHtml = $this->renderButton($button);
			if($buttonHtml) {
				echo $buttonHtml;
				echo $this->splitter;
			}
		}
	}
	
	private function renderButton($definition) {
		$definition = $this->normalizeDefinition($definition);
		/** @var BaseAction $actionInstance */
		$actionInstance = Yii::createObject($definition);
		return $actionInstance->render();
	}
	
	private function normalizeDefinition($definition) {
		if(is_string($definition)) {
			$definition = [
				'class' => $definition,
			];
		}
		if(empty($definition['class'])) {
			$definition['class'] = BaseAction::class;
		}
		$baseOptions = ArrayHelper::extractByKeys($this, [
			'baseUrl',
			'id',
			'iconTemplate',
			'urlTemplate',
			'linkOptions',
		]);
		$baseOptions = ArrayHelper::removeIfNull($baseOptions);
		$definition = ArrayHelper::merge($baseOptions, $definition);
		return $definition;
	}
	
}