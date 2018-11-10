<?php

namespace yii2lab\extension\git\domain\helpers;

use yii2lab\extension\common\helpers\StringHelper;
use yii2lab\extension\git\domain\entities\RefEntity;
use yii2lab\extension\package\domain\helpers\ConfigRepositoryHelper;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2mod\helpers\ArrayHelper;

class GitConfigHelper {
	
	/**
	 * @param RefEntity[] $refs
	 *
	 * @return array
	 */
	public static function getTagsByRefs($refs) {
		$tags = [];
		foreach($refs as $refEntity) {
			if($refEntity->type == 'tags') {
				$tags[] = [
					'hash' => $refEntity->hash,
					'value' => $refEntity->name,
				];
			}
			
		}
		return $tags;
	}
	
	public static function getRefs($dir) {
		$file = $dir . DS . '.git' . DS . 'info' . DS . 'refs';
		$data = FileHelper::load($file);
		$lines = StringHelper::textToLines($data);
		$refs = [];
		foreach($lines as $line) {
			if($line) {
				$item = explode(TAB, $line);
				$refs[] = [
					'hash' => $item[0],
					'value' => $item[1],
				];
			}
		}
		return $refs;
	}
	
	public static function loadIni($dir) {
		$iniFile = $dir . DS . '.git' . DS . 'config';
		$gitConfig = parse_ini_file($iniFile, true);
		$arr = [];
		foreach($gitConfig as $name => $value) {
			$rr = explode(SPC, $name);
			ArrayHelper::setValue($arr, implode(DOT, $rr), $value);
		}
		$arr['branch'] = self::assignName(ArrayHelper::getValue($arr, 'branch'));
		$arr['remote'] = self::assignName(ArrayHelper::getValue($arr, 'remote'));
		return $arr;
	}
	
	private static function assignName($array) {
		if(empty($array)) {
			return [];
		}
		$flatArray = [];
		foreach($array as $name => $value) {
			$item = $value;
			$item['name'] = $name;
			$flatArray[] = $item;
		}
		return $flatArray;
	}
	
}
