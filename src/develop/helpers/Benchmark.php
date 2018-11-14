<?php

namespace yii2lab\extension\develop\helpers;

use yii\web\ServerErrorHttpException;
use yii2lab\app\domain\helpers\EnvService;
use yii2lab\extension\store\StoreFile;
use yii2lab\extension\common\helpers\StringHelper;

class Benchmark {
	
	private static $data = [];
	private static $sessionId = null;
	
	public static function begin($name, $data = null) {
		$microTime = microtime(true);
		if(!self::isEnable()) {
			return;
		}
		$name = self::getName($name);
		$item['name'] = $name;
		$item['begin'] = $microTime;
		$item['data'] = [$data];
		self::append($item);
	}
	
	public static function end($name, $data = null) {
		$microTime = microtime(true);
		if(!self::isEnable()) {
			return;
		}
		$name = self::getName($name);
		if(!isset(self::$data[$name])) {
			return;
		}
		$item = self::$data[$name];
		if(isset($item['end'])) {
			return;
		}
		
		if(!isset($item['begin'])) {
			throw new ServerErrorHttpException('Benchmark not be started!');
		}
		$item['end'] = $microTime;
		if($data) {
			$item['data'][] = $data;
		}
		self::append($item);
	}
	
	public static function all() {
		return self::$data;
	}
	
	private static function getName($name) {
		if(is_string($name)) {
			return $name;
		}
		$scope = microtime(true) . BL . serialize($name);
		$hash = hash('md5', $scope);
		return $hash;
	}
	
	private static function isEnable() {
		return EnvService::get('mode.benchmark', false);
	}
	
	private static function getRequestId() {
		if(!self::$sessionId) {
			self::$sessionId = TIMESTAMP . DOT . StringHelper::generateRandomString();
		}
		return self::$sessionId;
	}
	
	private static function getFileName() {
		$dir = ROOT_DIR . '/common/runtime/logs/benchmark';
		$file = self::getRequestId() . '.json';
		return $dir . DS . $file;
	}
	
	private static function getStoreInstance() {
		$fileName = self::getFileName();
		$store = new StoreFile($fileName);
		return $store;
	}
	
	private static function append($item) {
		$name = $item['name'];
		if(!empty($item['end'])) {
			$item['duration'] = $item['end'] - $item['begin'];
		}
        self::$data[$name] = $item;
		if($item['duration']) {
            $store = self::getStoreInstance();
            $store->save([
                '_SERVER' => $_SERVER,
                'data' => self::$data,

            ]);
        }
	}
	
}