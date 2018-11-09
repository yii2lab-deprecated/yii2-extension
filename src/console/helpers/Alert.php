<?php

namespace yii2lab\extension\console\helpers;

class Alert {
	
	const LINE_LEN = 78;

    static function success($data, $title = '') {
        self::block($data, $title);
    }

	static function block($data, $title = '', $charBorder = '-', $charWrap = '') {
		$consoleLen = self::LINE_LEN - 2 - (mb_strlen($charWrap) * 2);
		$dataArr = str_split($data, $consoleLen);
		$tmp = '';
		foreach($dataArr as $str) {
			$tmp .= self::_item($str, $charWrap);
		}
		echo PHP_EOL;
		Output::pipe($title, $charBorder);
		//echo PHP_EOL;
		echo $tmp;
		echo PHP_EOL;
        Output::pipe('', $charBorder);
	}

    private static function _item($str, $charWrap = '|') {
        $consoleLen = self::LINE_LEN - 2 - (mb_strlen($charWrap) * 2);
        $len = mb_strlen($str);
        $spacesLen = $consoleLen - $len;
        $spaces = '';
        if($spacesLen > 0) {
            $spaces = str_repeat(' ', abs($spacesLen));
        }
        return $charWrap . ' ' . $str . $spaces . ' ' . $charWrap;
    }

}
