<?php

namespace yii2lab\extension\markdown\widgets\helpers;

use Yii;
use Michelf\MarkdownExtra;

class MarkdownHelper {

	public static function toHtml($source) {
		$html = self::md2html($source);
		return $html;
	}

	private static function md2html($source) {
		$markdown = new MarkdownExtra();
		$html = $markdown->transform($source);
		return $html;
	}

}
