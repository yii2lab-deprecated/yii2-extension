<?php

namespace yii2lab\extension\code\helpers;

use yii2lab\extension\code\entities\CodeEntity;
use yii2lab\extension\code\render\CodeRender;
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
		$code = CodeHelper::render($codeEntity);
		FileHelper::save($fileName, $code);
	}
	
	private static function render(CodeEntity $codeEntity) {
		$render = new CodeRender();
		$render->classEntity = $codeEntity;
		return $render->run();
	}
	
}
