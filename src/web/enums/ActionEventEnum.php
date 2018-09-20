<?php

namespace yii2lab\extension\web\enums;

use yii2lab\extension\enum\base\BaseEnum;

class ActionEventEnum extends BaseEnum {
	
	const BEFORE_READ = 'BEFORE_READ';
	const AFTER_READ = 'AFTER_READ';
	
	const BEFORE_WRITE = 'BEFORE_WRITE';
	const AFTER_WRITE = 'AFTER_WRITE';
	
	const BEFORE_DELETE = 'BEFORE_DELETE';
	const AFTER_DELETE = 'AFTER_DELETE';

}
