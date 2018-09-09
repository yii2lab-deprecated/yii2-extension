<?php

namespace yii2lab\extension\markdown\widgets\filters;

use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\markdown\widgets\helpers\HighlightHelper;

class CodeFilter extends BaseScenario {

	public function run() {
		$html = $this->getData();
		$html = $this->replace($html);
		$this->setData($html);
	}

	private function replace($html) {
		$pattern = '~<pre>\s*<code class=\"([\w]+)\">([\s\S]+?)</code>\s*</pre>~';
		$html = preg_replace_callback($pattern, function($matches) {
			$language = $matches[1];
			$content = html_entity_decode($matches[2]);
			$html = HighlightHelper::render($content, $language);
			return $html;
		}, $html);
		return $html;
	}
}
