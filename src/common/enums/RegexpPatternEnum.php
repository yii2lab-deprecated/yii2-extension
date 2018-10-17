<?php

namespace yii2lab\extension\common\enums;

use yii2lab\extension\enum\base\BaseEnum;

class RegexpPatternEnum extends BaseEnum {
	
	const BEGIN_REQUIRED = '#^';
	const END_REQUIRED = '$#';
	
	const HEX_CHAR = '[0-9a-f]';
	const HEX = self::HEX_CHAR . '+';
	const HEX_REQUIRED = self::BEGIN_REQUIRED . self::HEX . self::END_REQUIRED;
	
	const UUID = '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}';
	const UUID_REQUIRED = self::BEGIN_REQUIRED . self::UUID . self::END_REQUIRED;
	
	const BASE_64_CHAR = '[A-Za-z0-9+/=]';
	const BASE_64 = '[A-Za-z0-9+/]{2,}[=]*';
	const BASE_64_REQUIRED = self::BEGIN_REQUIRED . self::BASE_64 . self::END_REQUIRED;
	
}