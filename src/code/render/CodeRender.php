<?php

namespace yii2lab\extension\code\render;

use yii2lab\extension\code\entities\CodeEntity;

/**
 * Class CodeRender
 *
 * @package yii2lab\extension\code\render
 *
 * @property CodeEntity $entity
 */
class CodeRender extends BaseRender
{
	
	const LINE_START = '<?php' . PHP_EOL;
	const LINE_END = PHP_EOL . '?>';
	
	public function run() {
		$codeEntity = $this->entity;
		$code = self::LINE_START;
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
		if($codeEntity->code != null) {
			$code .= PHP_EOL;
			$code .= $codeEntity->code . PHP_EOL;
		}
		return $code;
	}
	
}
