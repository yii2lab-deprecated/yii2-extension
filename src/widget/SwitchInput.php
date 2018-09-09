<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @version 3.4.0
 */

namespace yii2lab\extension\widget;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Switch widget is a Yii2 wrapper for the Bootstrap Switch plugin by Mattia, Peter, & Emanuele.
 * This input widget is a jQuery based replacement for checkboxes and radio buttons and converts
 * them to toggle switches.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://www.bootstrap-switch.org/
 */
class SwitchInput extends \kartik\switchinput\SwitchInput
{

	const YES_NO = 'YES|NO';
	const ON_OFF = 'STATUS_ON|STATUS_OFF';

	public static function config($config = []) {
		$pluginOptions = [
			'pluginOptions' => [
				'handleWidth' => 80,
				'onText' => Yii::t('main', 'STATUS_ON'),
				'offText' => Yii::t('main', 'STATUS_OFF'),
				'onColor' => 'success',
				'offColor' => 'danger',
			]
		];
		$pluginOptions['pluginOptions'] = ArrayHelper::merge($pluginOptions['pluginOptions'], $config);
		return $pluginOptions;
	}

	public static function semanticConfig($pare = self::YES_NO, $config = []) {
		list($positive, $negative) = explode('|', $pare);
		$config['onText'] = Yii::t('main', $positive);
		$config['offText'] = Yii::t('main', $negative);
		return self::config($config);
	}

	public static function yesNoConfig($config = []) {
		$config['handleWidth'] = 50;
		return self::semanticConfig(self::YES_NO, $config);
	}

	public static function onOffConfig($config = []) {
		return self::semanticConfig(self::ON_OFF, $config);
	}
}
