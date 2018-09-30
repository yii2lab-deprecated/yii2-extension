<?php

namespace yii2lab\extension\common\exceptions;

use yii\base\Exception;

class DeprecatedException extends Exception {
	
	public function getName() {
		return 'DeprecatedException';
	}
}
