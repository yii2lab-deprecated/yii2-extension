<?php

namespace yii2lab\extension\widget\helpers;

class WidgetHelper {
	
	
	public static function renderTemplate($template, $config) {
		$configPrepared = self::prepareTemplateConfig($config);
		$html = strtr($template, $configPrepared);
		return $html;
	}
	
	private static function prepareTemplateConfig($config) {
		$configPrepared = [];
		foreach($config as $key => $value) {
			$keyPrepared = '{' . $key . '}';
			$configPrepared[$keyPrepared] = $value;
		}
		return $configPrepared;
	}
	
	
}
