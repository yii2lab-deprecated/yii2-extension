<?php

namespace yii2lab\extension\yuml\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii2lab\extension\yuml\helpers\UmlHelper;

/**
 * Class UmlDiagram
 *
 * @package yii2lab\extension\yuml\widgets
 *
 * @example https://yuml.me/diagram/scruffy/usecase/samples
 */
class UmlUseCase extends Widget {
	
	
	public $baseUrl = 'http://yuml.me/diagram/scruffy/usecase/';
	public $code;
	
	public function run() {
		$code = UmlHelper::prepareCode($this->code);
		$url = $this->baseUrl . $code;
		echo Html::img($url);
	}
	
}
