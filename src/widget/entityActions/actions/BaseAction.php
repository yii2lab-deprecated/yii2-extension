<?php

namespace yii2lab\extension\widget\entityActions\actions;

use yii\helpers\Url;
use yii2lab\extension\widget\helpers\WidgetHelper;
use yii2lab\extension\yii\helpers\Html;
use yii2module\lang\domain\helpers\LangHelper;

class BaseAction {
	
	public $baseUrl;
	public $id;
	public $iconTemplate = '<i class="fa fa-{name} text-{type}"></i>';
	public $urlTemplate = '/{base}/{action}?id={id}';
	public $linkOptions = [];
	
	public $icon;
	public $textType;
	public $action;
	public $title;
	public $data;
	
	public function render() {
		$iconHtml =  $this->renderTemplate('iconTemplate', [
			'name' => $this->icon,
			'type' => $this->textType,
		]);
		$url = $this->renderTemplate('urlTemplate', [
			'base' => $this->baseUrl,
			'action' => $this->action,
			'id' => $this->id,
		]);
		$url = Url::to($url);
		$anchorOptions = $this->linkOptions;
		$anchorOptions['title'] = LangHelper::extract($this->title);
		if($this->data) {
			$anchorOptions['data'] = $this->data;
		}
		return Html::a($iconHtml, $url, $anchorOptions);
	}
	
	private function renderTemplate($name, $options) {
		$template = $this->{$name};
		return WidgetHelper::renderTemplate($template, $options);
	}
	
}