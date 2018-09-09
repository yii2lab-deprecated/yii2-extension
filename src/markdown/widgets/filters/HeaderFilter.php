<?php

namespace yii2lab\extension\markdown\widgets\filters;

use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\extension\markdown\widgets\helpers\ArticleMenuHelper;
use yii2lab\extension\markdown\widgets\helpers\MarkdownHelper;

class HeaderFilter extends BaseScenario {
	
	public function run() {
		$html = $this->getData();
		$html = $this->replace($html);
		$this->setData($html);
	}
	
	private function replace($html) {
		$menu = ArticleMenuHelper::getMenuFromHtml($html);
		if(!empty($menu)) {
			$html = ArticleMenuHelper::addIdInHeaders($html);
		}
		$menuMd = ArticleMenuHelper::makeMenuMd($menu);
		$menuHtml = MarkdownHelper::toHtml($menuMd);
		$html = str_replace('</h1>', '</h1>' . $menuHtml . PHP_EOL, $html);
		return $html;
	}
	
}
