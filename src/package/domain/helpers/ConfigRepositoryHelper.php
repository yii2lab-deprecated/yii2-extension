<?php

namespace yii2lab\extension\package\domain\helpers;

use yii2lab\extension\yii\helpers\FileHelper;

class ConfigRepositoryHelper  {
	
	public static function idToDir($id) {
		$dir = FileHelper::getAlias('@vendor/' . $id);
		return $dir;
	}
	
}
