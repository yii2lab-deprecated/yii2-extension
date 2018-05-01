<?php

namespace yii2lab\extension\code\helpers;

use yii2lab\extension\code\entities\CodeEntity;
use yii2lab\helpers\yii\FileHelper;
use yii2lab\store\Store;

class CodeHelper extends BaseClassHelper
{
	
	public static function generatePhpData($alias, $data) {
		$store = new Store('php');
		$content = $store->encode($data);
		$codeEntity = new CodeEntity();
		$codeEntity->fileName = $alias;
		$codeEntity->code = 'return ' . $content . ';';
		self::save($codeEntity);
	}
	
	public static function save(CodeEntity $codeEntity) {
		$pathName = FileHelper::getPath('@' . $codeEntity->fileName);
		$fileName = $pathName . DOT . 'php';
		$code = CodeHelper::renderPhp($codeEntity);
		FileHelper::save($fileName, $code);
	}
	
	private static function renderPhp(CodeEntity $codeEntity) {
		$code = '<?php' . PHP_EOL;
		if($codeEntity->namespace != null) {
			$code .= PHP_EOL;
			$code .= 'namespace ' . $codeEntity->namespace . ';' . PHP_EOL;
		}
		if($codeEntity->uses != null) {
			$code .= PHP_EOL;
			foreach($codeEntity->uses as $useEntity) {
				$code .= 'use ' . $useEntity->name . ';' . PHP_EOL;
			}
		}
		$code .= PHP_EOL;
		if($codeEntity->code != null) {
			$code .= $codeEntity->code . PHP_EOL;
		}
		return $code;
	}
	
}
