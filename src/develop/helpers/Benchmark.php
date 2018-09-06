<?php

namespace yii2lab\misc\exception\develop\helpers;

use yii\web\ServerErrorHttpException;

class Benchmark {
	
	private static $data = [];
	
	public static function begin($name) {
		self::$data[$name]['begin'] = microtime(true);
	}
	
	public static function end($name) {
		if(isset(self::$data[$name]['end'])) {
			return;
		}
		if(!isset(self::$data[$name]['begin'])) {
			throw new ServerErrorHttpException('Benchmark not be started!');
		}
		self::$data[$name]['end'] = microtime(true);
	}
	
	public static function prr($name) {
		self::end($name);
		$item = self::$data[$name];
		$duration = $item['end'] - $item['begin'];
		prr('Duration: ' . $duration,1);
	}
	
}