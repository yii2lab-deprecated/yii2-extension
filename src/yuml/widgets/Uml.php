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
class Uml extends Widget {
	
	const TYPE_USE_CASE = 'use-case';
	const TYPE_CLASS = 'class';
	const TYPE_ACTIVITY = 'activity';
	const URLS = [
		self::TYPE_USE_CASE => 'http://yuml.me/diagram/scruffy/usecase/',
		self::TYPE_CLASS => 'http://yuml.me/diagram/scruffy/class/',
		self::TYPE_ACTIVITY => 'http://yuml.me/diagram/scruffy/activity/',
	];
	
	public $code;
	public $type;
	
	public function run() {
		$baseUrl = $this->getUrlByType($this->type);
		$code = $this->code;
		$url = $baseUrl . $code;
		echo Html::img($url);
	}
	
	public function getUrlByType($type) {
		return self::URLS[$type];
	}
	
	public function setLines($lines) {
		$code = UmlHelper::lines2string($lines);
		$this->code = $code;
	}
	
}
