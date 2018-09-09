<?php

namespace yii2lab\extension\markdown\widgets\filters;

use yii\helpers\Url;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2module\guide\module\helpers\NavigationHelper;

class LinkFilter extends BaseScenario {
	
	public function run() {
		$html = $this->getData();
		
		$html = $this->replaceGithubFileLink($html);
		$html = $this->replaceGithubDirectoryLink($html);
		$html = $this->replaceExternalLink($html);
		$html = $this->replaceInternalLink($html);
		
		$this->setData($html);
	}
	
	private function replaceGithubFileLink($html) {
		$pattern = '~<a href="https://github.com/(.+)/(.+)/blob/.+/guide/.+/(.+).md">([^<]+)?</a>~';
		$callback = function ($matches) {
			$url[] = NavigationHelper::URL_ARTICLE_VIEW;
			$url['project_id'] = $matches[1] . '.' . $matches[2];
			$url['id'] = $matches[3];
			return '<a href="'.Url::to($url).'">'.$matches[4].'</a>';
		};
		$html = preg_replace_callback($pattern, $callback, $html);
		return $html;
	}
	
	private function replaceGithubDirectoryLink($html) {
		$pattern = '~<a href="https://github.com/(.+)/(.+)/tree/.+/guide/.+">([^<]+)?</a>~';
		$callback = function ($matches) {
			$url[] = NavigationHelper::URL_ARTICLE_INDEX;
			$url['project_id'] = $matches[1] . '.' . $matches[2];
			return '<a href="'.Url::to($url).'">'.$matches[3].'</a>';
		};
		$html = preg_replace_callback($pattern, $callback, $html);
		return $html;
	}
	
	private function replaceInternalLink($html) {
		$pattern = '~<a href="(.+).md">([^<]+)?</a>~';
		$callback = function ($matches) {
			$url = NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_VIEW);
			$url['id'] = $matches[1];
			return '<a href="'.Url::to($url).'">'.$matches[2].'</a>';
		};
		$html = preg_replace_callback($pattern, $callback, $html);
		return $html;
	}

	private function replaceExternalLink($html) {
		$pattern = '~<a href="(http[^\"]+)">([^<]+)?</a>~';
		$replacement = '<a href="$1" target="_blank">$2</a>';
		$html = preg_replace($pattern, $replacement, $html);
		return $html;
	}

}
