<?php

namespace yii2lab\extension\markdown\widgets;

use yii\apidoc\templates\bootstrap\assets\AssetBundle;
use yii\base\Widget;
use yii2lab\extension\scenario\helpers\ScenarioHelper;
use yii2lab\extension\markdown\widgets\helpers\MarkdownHelper;

class Markdown extends Widget {

	public $content;
	public $filters = [
		'yii2lab\extension\markdown\widgets\filters\AlertFilter',
		'yii2lab\extension\markdown\widgets\filters\CodeFilter',
		'yii2lab\extension\markdown\widgets\filters\ImgFilter',
		'yii2lab\extension\markdown\widgets\filters\LinkFilter',
		'yii2lab\extension\markdown\widgets\filters\MarkFilter',
		//'yii2lab\extension\markdown\widgets\filters\HeaderFilter',
	];

	public function init() {
		parent::init();
		$this->registerAssets();
	}
	
	/**
	 * @return string
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public function run() {
		$html = MarkdownHelper::toHtml($this->content);
		$filterCollection = ScenarioHelper::forgeCollection($this->filters);
		return ScenarioHelper::runAll($filterCollection, $html);
	}

	protected function registerAssets() {
		$view = $this->getView();
		AssetBundle::register($view);
	}

}