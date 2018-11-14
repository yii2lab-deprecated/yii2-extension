<?php

namespace yii2lab\extension\yuml\helpers;

use yii2lab\extension\common\helpers\StringHelper;

class UmlHelper
{

    public static function lines2string($arr) {
	    $code = implode(', ', $arr);
	    $code = self::prepareCode($code);
	    return $code;
    }
	
	public static function prepareCode($code) {
	    $code = StringHelper::removeDoubleSpace($code);
	    $code = trim($code);
	    return $code;
    }
}
