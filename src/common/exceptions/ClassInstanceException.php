<?php

namespace yii2lab\extension\common\exceptions;

use Throwable;
use yii\base\Exception;

class ClassInstanceException extends Exception {
	
	public function getName() {
		return 'ClassInstanceException';
	}
	
	public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
		
		parent::__construct($message, $code, $previous);
	}
}
