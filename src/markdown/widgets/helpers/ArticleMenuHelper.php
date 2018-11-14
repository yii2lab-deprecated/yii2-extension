<?php

namespace yii2lab\extension\markdown\widgets\helpers;

use yii2lab\extension\common\helpers\StringHelper;
use yii2lab\extension\yii\helpers\Html;

class ArticleMenuHelper {
	
	const HEADER_PATTERN = '~<h([2-6]{1}).*>(.+)</h[2-6]{1}.*>~m';
	const HEADER_PATTERN1 = '~^([#]+)\s+(.+)$~m';
	
	public static function makeMenuMd($menu) {
		$headersMd = PHP_EOL;
		$min = self::getMinMargin($menu);
		foreach($menu as $item) {
			$link = Html::a($item['content'], '#'.$item['name']);
			$headersMd .= str_repeat(TAB, $item['level'] - $min) . '*' . SPC . $link . PHP_EOL;
		}
		return $headersMd;
	}
	
	public static function addIdInHeaders($html) {
		$count = 0;
		$callback = function($matches) use(&$count) {
			$count++;
			$item = self::buildMenuItem([
				'level' => $matches[1],
				'content' => $matches[2],
				'order' => $count,
			]);
			$rightContent = '';
			$rightContent .= Html::a(Html::fa('hashtag', ['class' => ''], 'fa fa-', 'small'), '#' . $item['name']);
			$rightContent .= NBSP;
			$rightContent .= Html::a(Html::fa('arrow-up', ['class' => ''], 'fa fa-', 'small'), '#go_to_top');
			$tagHtml = self::buildHeader($item, '<span class="pull-right">'.$rightContent.'</span>');
			return $tagHtml;
		};
		$html = preg_replace_callback(self::HEADER_PATTERN, $callback, $html);
		return $html;
	}
	
	public static function getMenuFromHtml($html) {
		$count = 0;
		$menu = [];
		$callback = function($matches) use(&$menu, &$count) {
			$count++;
			$item = self::buildMenuItem([
				'level' => $matches[1],
				'content' => $matches[2],
				'order' => $count,
			]);
			if(!empty($item['content'])) {
				$menu[$item['name']] = $item;
			}
		};
		preg_replace_callback(self::HEADER_PATTERN, $callback, $html);
		return $menu;
	}
	
	public static function getMenuFromMarkdown($md) {
		$count = 0;
		$menu = [];
		$callback = function($matches) use(&$menu, &$count) {
			$count++;
			$item = self::buildMenuItem([
				'level' => $matches[1],
				'content' => $matches[2],
				'order' => $count,
			]);
			if(!empty($item['content'])) {
				$item['content'] = trim($item['content']);
				$menu[$item['name']] = $item;
			}
		};
		preg_replace_callback(self::HEADER_PATTERN1, $callback, $md);
		return $menu;
	}
	
	private static function getMinMargin($menu) {
		$min = 10;
		foreach($menu as $item) {
			if($item['level'] < $min) {
				$min = $item['level'];
			}
		}
		return $min;
	}
	
	private static function buildHeader($item, $rightContent) {
		$tagContent = $rightContent . $item['content'];
		$tagName = 'h' . $item['level'];
		$tagHtml = Html::tag($tagName, $tagContent, ['id' => $item['name']]);
		return $tagHtml;
		
	}
	
	private static function buildMenuItem($item) {
		$item['level'] = intval($item['level']);
		$item['content'] = strip_tags($item['content']);
		$item['order'] = intval($item['order']);
		$item['name'] = self::headerName($item);
		return $item;
	}
	
	private static function headerName($item) {
		$scope = serialize($item);
		$hash = hash('crc32b', $scope);
		$name = $item['content'] . BL . $hash;
		$name = mb_strtolower($name);
		$nameArray = StringHelper::getWordArray($name);
		$name = implode('-', $nameArray);
		$name = trim($name,  ' -');
		$name = str_replace([' ', '#', '?'], '-', $name);
		return $name;
	}
	
}
