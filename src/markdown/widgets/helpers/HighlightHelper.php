<?php

namespace yii2lab\extension\markdown\widgets\helpers;

use Highlight\Highlighter;

class HighlightHelper {

	public static $autodetectLanguages = [
		'apache', 'nginx',
		'bash', 'dockerfile', 'http',
		'css', 'less', 'scss',
		'javascript', 'json', 'markdown',
		'php', 'sql', 'twig', 'xml',
	];
	private static $highlighter;

	public static function render($content, $language = null) {
		$highlighter = self::initHighlighter();
		if (isset($language)) {
			$result = $highlighter->highlight($language, $content);
			$class = "{$result->language} language-{$language}";
		} else {
			$result = $highlighter->highlightAuto($content);
			$class = $result->language;
		}
		return "<pre><code class=\"hljs {$class}\">{$result->value}</code></pre>";
	}

	private static function initHighlighter() {
		if (self::$highlighter === null) {
			self::$highlighter = new Highlighter();
			self::$highlighter->setAutodetectLanguages(self::$autodetectLanguages);
		}
		return self::$highlighter;
	}

}