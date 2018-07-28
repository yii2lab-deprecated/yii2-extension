<?php

namespace yii2lab\extension\filedb\base;

use Yii;
use yii2lab\app\domain\helpers\EnvService;
use yii2mod\helpers\ArrayHelper;

class FiledbActiveRecord extends \yii2tech\filedb\ActiveRecord {
	
	const DEFAULT_PATH = '@common/data';
	
	public function attributes() {
		static $attributes;
		if ($attributes === null) {
			$rows = static::getDb()->readData(static::fileName());
			if(empty($rows)) {
				$schema = static::getDb()->readData('schema' . SL . static::fileName());
				$attributes = ArrayHelper::getColumn($schema, 'name');
			} else {
				$attributes = array_keys(reset($rows));
			}
		}
		return $attributes;
	}
	
	public static function getDb() {
		if(!Yii::$app->has('filedb')) {
			$path = EnvService::getServer('filedb.path', self::DEFAULT_PATH);
			Yii::$app->set('filedb', [
				'class' => 'yii2tech\filedb\Connection',
				'path' => $path,
			]);
		}
		return parent::getDb();
	}
}